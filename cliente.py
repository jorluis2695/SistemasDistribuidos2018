
import sys
import glob
sys.path.append('gen-py')
sys.path.insert(0, glob.glob('/home/ubuntu/thrift/thrift-0.11.0/lib/py/build/lib*'[0]))

from gif import Gifsv

from thrift import Thrift
from thrift.transport import TSocket
from thrift.transport import TTransport
from thrift.protocol import TBinaryProtocol

def main():
	ti = time.time()

    transport = TSocket.TSocket('localhost', 9999)

    transport = TTransport.TBufferedTransport(transport)

    protocol = TBinaryProtocol.TBinaryProtocol(transport)
    
    client = Gifsv.Client(protocol)

    transport.open()


    topGifs = client.TopGifs("todos")
    count = 0   
    tf = time.time()
    print(tf-ti)
    transport.close()

if __name__ == '__main__':
    try:
        main()
    except Thrift.TException as tx:
        print('%s' % tx.message)


