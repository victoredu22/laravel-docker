### Descripción del proyecto

Api biblioteca creada con laravel, mysql y docker, la cual contiene un sistema de libro que realiza entrega a distintos alumnos, la forma de authentificación es mediante jwt, todas las rutas estan protegidas mediante a un token.

- Permite crear, editar y eliminar libros- Permite ver estudiantes mediante rut y también el total
- Se pueden ver todas las propiedades de los cursos
- Permite crear, editar y eliminar envíos de libros a estudiantes
- Sistema de autenticación mediante jwt
- Inclusión de factories y migrations para la recolección de datos

### Tecnologias involucradas

- Docker para la virtualización del proyecto
- Mysql para guardar los datos
- Laravel en su versión 6 para la creación de la api
- nginx servidor encargado de mantener los servicios andando
- jwt para la autenticación mediante tokens


### Requisitos previos:
Instalar docker en su versión linux o windows y luego ejecutar las siguientes instrucciones

- Creación contenedor
```bash docker-compose up -d --build ```

- Luego comprobar si el contenedor está corriendo

```bash docker-compose ps ```

Ahora necesitas ingresar a la consola php, para instalar composer dentro del proyecto y crear una nueva key

- Linux

```bash docker-compose exec app bash ```

- Windows 

```bash winpty docker exec -it nginx sh ```

Una vez dentro instalar composer

```bash composer install ```

- Key env, para esto debes copiar el env.example y crearlo en un nuevo llamado .env de tu proyecto

```bash php artisan key:generate ```

## Scrips para la inilización del proyecto
- Para Crear el contenedor ejecutar

```bash docker-compose up ```

## los puertos expuestos son los siguientes: 

- localhost:8888 => laravel
- localhost:33069 => mysql
