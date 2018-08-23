
import redis
import glob
import sys
import MySQLdb
import requests
import logging

sys.path.append('gen-py')
sys.path.insert(0, glob.glob('/home/ubuntu/thrift/thrift-0.11.0/lib/py/build/lib*'[0]))

from gif import Gifsv
from thrift.transport import TSocket
from thrift.transport import TTransport
from thrift.protocol import TBinaryProtocol
from thrift.server import TServer


class GifsvHandler:
	def __init__(self):
		self.log = {}
		self.r = redis.StrictRedis(host='localhost', port=6379, db=0)
	def TopGifs(self, tag):
		popular_gifs = self.r.smembers(tag)
		if not popular_gifs:
			lista_gifs = self.info(tag)
			print("Leido de la Base de Datos y Cacheado")
			print(len(lista_gifs))
			return lista_gifs
		else:
			print("Leido de la Cache")
			print(len(popular_gifs))
			return popular_gifs



	def info(self, tag):
		mydb = MySQLdb.connect(
			host = "127.0.0.1",
			user = "root",
			passwd = "root1234",
			db = "dbgifs"
			)

		puntero = mydb.cursor()


		if tag == 'todos':
			puntero.execute("SELECT name FROM gifs ORDER BY popularidad DESC LIMIT 10")
		elif tag == 'dog':
			puntero.execute("SELECT name FROM gifs WHERE tag = 'dog' ORDER BY popularidad DESC LIMIT 10")
		elif tag == 'cat':
			puntero.execute("SELECT name FROM gifs WHERE tag = 'cat' ORDER BY popularidad DESC LIMIT 10")
		elif tag == 'sports':
			puntero.execute("SELECT name FROM gifs WHERE tag = 'sports' ORDER BY popularidad DESC LIMIT 10")

		lista_gifs = []
		for x in puntero:
			res = (requests.get(x[0])).content
        		self.r.sadd(tag, res)
			lista_gifs.append(res)
		self.r.expire(tag, 60)
		return lista_gifs



if __name__ == '__main__':
	try:
		handler = GifsvHandler()
		processor = Gifsv.Processor(handler)
		transport = TSocket.TServerSocket(host='127.0.0.1', port=9999)
		tfactory = TTransport.TBufferedTransportFactory()
		pfactory = TBinaryProtocol.TBinaryProtocolFactory()

		server = TServer.TThreadedServer(processor, transport, tfactory, pfactory)
		print('Its dangerous go alone')
		print('Take this server')
		server.serve()
		logging.basicConfig(level=logging.DEBUG)
	except:
		print("error")
