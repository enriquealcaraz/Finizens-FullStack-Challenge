## Levantar la aplicacion
En el directorio raiz del desarrollo

- docker-compose up
- docker-compose run --rm app cp .env.dev .env
- docker-compose run --rm app composer install
- docker-compose run --rm app php artisan migrate

## Ejecutar test
- php artisan test

## Back
El back se ha realizado con el framework de laravel.

## Frontal
El front se ha realizado todo en la vista de bienvenida de laravel para ahorrar 
tiempo. Por lo tanto al cargar la página hará las llamadas necesarias al back
para traerse la información que necesita.

- http://localhost:8080/

## Notas
Al iniciar el contenedor de docker se creará una orden de compra sin completar junto
con sus allocations. Al utilizar el endpoint /portfolio no se creará ninguna orden de
compra, se borrarán todos los datos asociados a ese portfolio y dejará las allocation iniciales. 
