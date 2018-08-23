from urllib import request
import random

archivo = open("gifs.txt", "r")
archivo2 = open("script.sql", "w")
archivo2.write('use dbgifs\n')
for m in range (0, 60):
    gifs = archivo.readline().rstrip()
    datos = gifs.split(',')
    # print(datos)
    uri = datos[0]
    name = 'gifs' +'/'+ datos[1]+'/'+datos[1]+'_'+str(m)+'.gif'
    name = 'https://s3-us-west-2.amazonaws.com/jlcedeno/' + name
    fama = random.randint(0, 100)
    # f = open(name, "w+")
    sol = 'INSERT INTO gifs ( id, name, tag ,popularidad ) VALUES ( null, "' + name + '","'+ datos[1] +'" ,' + str(fama) + ');\n'
    print(sol)
    archivo2.write(sol)
    # request.urlretrieve(uri, name, tag)

