# SistemasDistribuidos2018
Descripción
Sistema web, con una arquitectura de microservicios y una caché para reducir la latencia de acceso a la base de datos. El sistema será uno que permite ver los diez gifs animados más populares de un sistema (top 10, en popularidad). Los gifs, con sus contadores de acceso, deberán estar almacenadas en una base de datos. El sistema web deberá contactar a un microservicio que le retorna los top 10 gifs, para su render en una página HTML, al usuario final. Para evitar saturar la base de datos, deberán usar una caché en la cual se almacenará el resultado del query, por ejemplo:
SELECT DISTINCT *
FROM gifs_animados
ORDER BY
num_accesos
LIMIT 10
Es decir, cuando se invoca el microservicio, ustedes deben:
1) Verificar si el resultado del query ya está cargado en la caché (ej.: get <key> en Redis o
Memcached, donde <key> puede ser un string que represente la fecha del día de hoy,
dado que el top 10 de gifs debe cambiar cada día).
2) Si el resultado estaba en la caché, retornarlo al usuario.
3) Si el resultado no estaba en la caché, ejecutar el query SQL en la BD, almacenarlo en la
caché (para que de ahora en adelante ya esté cacheado), y retornarlo al usuario.

Página web utilizando los servicios de AWS [http://34.219.222.210/gifs_project/clientphp.php](http://34.219.222.210/gifs_project/clientphp.php)
