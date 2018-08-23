# SistemasDistribuidos2018
Descripción
Sistema web, con una arquitectura de microservicios y una caché para reducir la latencia de acceso a la base de datos. El sistema será uno que permite ver los diez gifs animados más populares de un sistema (top 10, en popularidad). Los gifs, con sus contadores de acceso, deberán estar almacenadas en una base de datos. El sistema web deberá contactar a un microservicio que le retorna los top 10 gifs, para su render en una página HTML, al usuario final. Para evitar saturar la base de datos, deberán usar una caché en la cual se almacenará el resultado del query, por ejemplo:


En este repositorio se puede encontrar lo necesario para replicar el trabajo:
  - En la carpeta Scripts, se encunetra un Script de Python donde se crea el script sql necesario para llenar la base de datos, basándose en los scripts que se encuentran en el archivo gifs.txt
  - En el archivo servidor.py es donde se encuentra el microservicio, el cual se encarga de conectarse a Redis, para ver si se encuentra cacheado el requerimiento, caso contrario, lo consulta de la base de datos y lo cachea. Luego de esto devuelve la respuesta al cliente que invoque el método topGifs(tag)  donde el tag quiere decir la etiqueta que tiene en la base de datos, en este caso "cat", "dog", "sports".  Para cachear se usa esta misma etiqueta y se le pone un tiempo de expiración de 60 segundos, además para cachear en el caso que se quiera buscar el top 10 de todos los Gifs sin importar el tag, se usa el tag "todos" (solo en Redis).  Tener en cuenta cambiar poner los datos correctos para conectarse a Redis y a la Base de datos.
  - En el archivo gif.thrift se encuentra la estructura Gif, seguidamente del servicio Gifsv, el cual se encuentra determinado el método topGifs(tag) que retorna una lista de los gifs pero en binario.
  - Es necesario generar los archivos para la comunicación entre nuestro cliente php con el servidor/microservicio en python a través del comando ``` thrift -gen py gif.thrift ``` y ```thrift -gen php gif.thrift ```.
  - En el archivo clientphp.php se encuentra la forma de cómo llamar el API Apache Thrift y comunicarse a através de los archivos generados por los comandos anteriores. Tomar en cuentra la ruta de THRIFT_ROOT editarla acorde a su proyecto, así como también el puerto y la ip del host, cabe aclarar que el puerto debe ser el mismo tanto en el cliente como en el servidor. Finalmente, se muestran los Top 10 gifs (depende de la selección del usuario).
  
  

Página web utilizando los servicios de AWS [http://34.219.222.210/gifs_project/clientphp.php](http://34.219.222.210/gifs_project/clientphp.php)
