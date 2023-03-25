<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/d/total.svg" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/license.svg" alt="License"></a>
</p>

## Sobre el proyecto

Usando PHP/Laravel gestiona el recurso “Cuadros”
los cuales solo puedan ser accedidos por determinados “Usuarios” que tengan
un rol particular.

- Esta aplicación es una API RESTful.
- Tiene los endpoints necesarios para “Crear”, “Consultar”, “Modificar” y “Borrar”.
- Recibe en el header de cada solicitud **X-HTTP-USER-ID** el **ID** del **usuario** que desea usar este
recurso.
- Se pueda “Consultar” el listado de “Cuadros” filtrando por cualquier campo y
  permita elegir qué campos mostrar en la respuesta.

## Caracteristicas Esenciales

#### - El proyecto cuenta con la configuración necesaria para realizar el deploy mediante **DOCKER-COMPOSE**
#### - El proyecto cuenta con la configuración necesaria en el archivo **.env.example** para acceder a una base de datos POSTGRES dentro del contenedor.
### Packages Externos

- laravel/passport
- spatie/laravel-permission
## Despliegue

- Clonar el repositorio en el entorno deseado: ``git clone git@github.com:matiasgonzalo/paintings.git matiasAcostaChallenge``
- Acceder al directorio del proyecto y copiar el archivo **.env.example** y renombrarlo por **.env**
- Construir y levantar el contenedor con los recursos necesarios: ``docker-compose up -d``
- Acceder al contenedor: ``docker-compose exec extendeal_webapp bash``
- Instalar dependencias: ``composer install``
- Generar la key del proyecto: ``php artisan key:generate``
- Ejecutar migraciones y seeders con datos de prueba: ``php artisan migrate --seed``
- Instalar passport: ``php artisan passport:install``

#### - Se crearán tres usuarios **Ruben**, **Matias** y **Gonzalo** con los roles **OWNER** para los usuarios **Ruben**, y **EMPLOYEE** para el usuario **Matias** y **Gonzalo**.

#### - Se crearán **20** objetos de la clase **Painting** *(Cuadro)*.

## Estructa de rutas disponibles

### **Relacionadas a la Autenticación**

- Login: (GET) **[http://localhost:8095/api/v1/oauth/login](http://localhost:8095/api/v1/oauth/login)**
- Ejemplo:
``curl --location 'http://localhost:8095/api/v1/oauth/login' \
--header 'Content-Type: application/json' \
--header 'Accept: application/json' \
--data-raw '{
    "email":"ruben@gmail.com",
    "password":"password"
}'``

### **Relacionadas al recurso Painting (Cuadro)** *(solo accedidas a partir de un usuario con Rol OWNER)*

#### Campos disponibles para ordenamiento: 'name', 'painter', 'date', 'style', 'country'.
#### Campos disponibles para filtros: 'name', 'painter', 'country', 'date', 'day', 'month', 'year', 'style', 'width', 'hight'.

- Muestra un recurso: (GET) **[http://localhost:8095/api/v1/paintings/1](http://localhost:8095/api/v1/paintings/1)**
- Ejemplo:
``curl --location 'http://localhost:8095/api/v1/paintings/30' \
--header 'Content-Type: application/json' \
--header 'Accept: application/json' \
--header 'x-http-user-id: 1' \
--header 'Authorization: Bearer token' \
--data ''``
- Muestra un listado: (GET) **[http://localhost:8095/api/v1/paintings](http://localhost:8095/api/v1/paintings)**
- Ejemplo:
``curl --location 'http://localhost:8095/api/v1/paintings' \
--header 'Content-Type: application/json' \
--header 'Accept: application/json' \
--header 'x-http-user-id: 1' \
--header 'Authorization: Bearer token' \
--data ''``
- Muestra un listado ordenado por campos específicos (name) ascendente: (GET) **[http://localhost:8095/api/v1/paintings?sort=name](http://localhost:8095/api/v1/paintings?sort=name)**
- Muestra un listado ordenado por campos específicos (name) descendete: (GET) **[http://localhost:8095/api/v1/paintings?sort=-name](http://localhost:8095/api/v1/paintings?sort=-name)**
- Muestra un listado ordenado por multiples campos (name, painter): (GET) **[http://localhost:8095/api/v1/paintings?sort=-name,painter](http://localhost:8095/api/v1/paintings?sort=-name,painter)**
- Muestra un listado paginado: (GET) **[http://localhost:8095/api/v1/paintings?page[size]=2&page[number]=2](http://localhost:8095/api/v1/paintings?page[size]=2&page[number]=2)**
- Muestra un listado filtrado por campos específicos: (GET) **[http://localhost:8095/api/v1/paintings?filter[year]=2022&filter[mounth]=02](http://localhost:8095/api/v1/paintings?filter[year]=2022&filter[mounth]=02)**
- Muestra un listado compuesto por campos específicos: (GET) **[http://localhost:8095/api/v1/paintings?fields[paintings]=name,painter](http://localhost:8095/api/v1/paintings?fields[paintings]=name,painter)**
- Almacena un recurso: (POST) **[http://localhost:8095/api/v1/paintings](http://localhost:8095/api/v1/paintings)**
- Ejemplo:
``curl --location 'http://localhost:8095/api/v1/paintings' \
--header 'Content-Type: application/json' \
--header 'Accept: application/json' \
--header 'Authorization: Bearer token' \
--header 'x-http-user-id: 1' \
--data '{
    "data" : {
        "type" : "paintings",
        "attributes" : {
            "code"      : "abcdefghijk12345",
            "name"      : "Matias",
            "painter"   : "Monalisa",
            "country"   : "Argentina",
            "date"      : "1993-01-01",
            "style"     : "Clasico",
            "width"     : 1000,
            "hight"     : 1000
        }
    }
}'``
- Actualiza un recurso: (PATCH) **[http://localhost:8095/api/v1/paintings/1](http://localhost:8095/api/v1/paintings/1)**
``curl --location --request PATCH 'http://localhost:8095/api/v1/paintings/1' \
--header 'Content-Type: application/json' \
--header 'Accept: application/json' \
--header 'Authorization: Bearer token' \
--data '{
    "data" : {
        "type" : "paintings",
        "attributes" : {
            "code"      : "abcdefghijk12345",
            "name"      : "Matias",
            "painter"   : "Monalisa",
            "country"   : "Argentina",
            "date"      : "1993-01-01",
            "style"     : "Clasico",
            "width"     : 1000,
            "hight"     : 1000
        }
    }
}'``
- Elimina un recurso: (DELETE) **[http://localhost:8095/api/v1/paintings/1](http://localhost:8095/api/v1/paintings/1)**
``curl --location --request DELETE 'http://localhost:8095/api/v1/paintings/1' \
--header 'Content-Type: application/json' \
--header 'Accept: application/json' \
--header 'Authorization: Bearer token'``

### **Relacionadas al recurso User** *(solo accedidas a partir de un usuario autenticado)*

#### Campos disponibles para ordenamiento: 'name', 'email'.
#### Campos disponibles para filtros: 'name', 'email'.

- Muestra un recurso: (GET) **[http://localhost:8095/api/v1/users/1](http://localhost:8095/api/v1/users/1)**
- Muestra un listado: (GET) **[http://localhost:8095/api/v1/users](http://localhost:8095/api/v1/users)**
- Muestra un listado ordenado por campos específicos (name) ascendente: (GET) **[http://localhost:8095/api/v1/users?sort=name](http://localhost:8095/api/v1/users?sort=name)**
- Muestra un listado ordenado por campos específicos (name) descendete: (GET) **[http://localhost:8095/api/v1/users?sort=-name](http://localhost:8095/api/v1/users?sort=-name)**
- Muestra un listado ordenado por multiples campos (name, email): (GET) **[http://localhost:8095/api/v1/users?sort=-name,email](http://localhost:8095/api/v1/users?sort=-name,email)**
- Muestra un listado paginado: (GET) **[http://localhost:8095/api/v1/users?page[size]=2&page[number]=2](http://localhost:8095/api/v1/users?page[size]=2&page[number]=2)**
- Muestra un listado filtrado por campos específicos: (GET) **[http://localhost:8095/api/v1/users?filter[name]=Matias&filter[email]=matias](http://localhost:8095/api/v1/users?filter[name]=Matias&filter[email]=matias)**
- Muestra un listado compuesto por campos específicos: (GET) **[http://localhost:8095/api/v1/users?fields[users]=name](http://localhost:8095/api/v1/users?fields[users]=name)**
- Almacena un recurso: (POST) **[http://localhost:8095/api/v1/users](http://localhost:8095/api/v1/users)**

## Testing *(58 tests, 157 aserciones)*

- Acceder al contenedor: ``docker-compose exec extendeal_webapp bash``
- Ejecutar todos los test automáticos: ``./vendor/bin/phpunit``
- Ejecutar test de clases especificas: ``./vendor/bin/phpunit --filter CreatePaintingTest``
- Ejecutar test de funciones especificas: ``./vendor/bin/phpunit --filter CreatePaintingTest::can_create_painting``

## Autor

Este proyecto fue desarrollado por [Acosta Matias Gonzalo](https://github.com/matiasgonzalo).
