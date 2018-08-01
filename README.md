# EATA tickets

#### Consumir una API
En este apartado, habrá que solicitar un listado de eventos a una API y permitir que el usuario seleccione las entradas 
que desea.

1. Obtener listado de `Event` de la API.
2. El usuario puede seleccionar uno de los `Event`.
3. Obtener listado de `Ticket` del `Event`.
4. Mostrar un formulario con los distintos tipos de `Ticket` para que el usuario elija la cantidad de cada uno de ellos 
que desee.
5. Crear un pedido mediante la API con la selección del usuario.
6. Si la petición es correcta, la API devolverá un objeto de tipo `Order`, con un conjunto de lineas que corresponden a 
los `Ticket` seleccionados.
7. El `Order` y sus `OrderLine`, tienen una propiedad `uuid`. Se deberá generar tantos códigos aleatorios como entradas 
haya comprado el usuario.
8. Enviar un email al usuario con los códigos generados.

**Api Key** `CfSQhOlbgbgH89e3PCvklQ==` [Documentación](http://devtest.entradasatualcance.com/api/v1/doc)

####Crear una API
Hay que desarrollar una pequeña API para la comprobación de los códigos de entradas que se han emitido previamente.

1. La API tendrá un web service que recibirá un código de entrada (por ejemplo: 1234567890asdfghjkl).
2. Se comprueba si el código es correcto, y si ha sido usado previamente o no.
3. En caso de una entrada ya utilizada o incorrecta, se devuelve un error con el motivo y el número de pedido, así como 
la hora de uso, si corresponde.
4. Si la entrada es correcta, devolverá el `uuid` del `Order` y el de su correspondiente `OrderLine`, así como el tipo 
de `Ticket` al que pertenece el código.

## Installation

* Install dependencies with composer dependency manager: `composer install`.
* [Optional] Create a file named `.env.local` in the project root and copy the content of `.env`. You can also customize 
parameters as you consider.
* Create the database with `bin/console doctrine:database:create` and the schema with 
`bin/console doctrine:schema:create`
* Serve the application locally with the web server bundle `bin/console server:run` or with a php server if you prefer 
`php -S localhost:8000 -t public/`.
* Open [the application](http://localhost:8000/api) with your favourite web browser.
