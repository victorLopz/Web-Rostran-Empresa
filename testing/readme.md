
## Requerimientos

- Composer y PHP
- Servicio MYSQL  


## Install

Seguir estos procedimientos para instalar proyecto, luego de clonarlo



- Correr Composer install en la terminal
- Copiar archivo .env.example a un nuevo archivo llamado .env en la raiz del proyecto
- Crear base de datos en el servicio mysql con el nombre rostran
- Ejecutar Php Artisan Migrate en la terminal para crear las tablas de la base de datos
- Ejecutar php artisan serve para correr finalmente

## Acceder Fotos

- Ruta {UrlSitioWeb} /storage/productos/ {Nombre Producto en la columna foto}

## Rutas 

- Revisar rutas disponibles en Routes/Api.php
