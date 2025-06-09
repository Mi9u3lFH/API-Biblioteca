# API Biblioteca — Laravel 12 + Docker

API RESTful para la gestión de libros y autores en una biblioteca, desarrollada con Laravel y contenedores Docker.
Incluye autenticación, control de roles, auditoría de cambios exportación a Excel y CRUD por API para autores y libros.

---

## Requisitos

- Docker Desktop
- Docker Compose
- Postman para pruebas

---

## Instalación y puesta en marcha

### 1. Clona el repositorio

```bash
git clone https://github.com/Mi9u3lFH/API-Biblioteca.git
cd api_biblioteca
```

### 2. Copia el contenido del ejemplo del .env al archivo .env

Al tratarse de una prueba, ya se incluye toda la configuración necesaria en el ejemplo

```bash
cp .env.example .env
```

### 3. Crea y levanta el contenedor docker

Crea la aplicación de PHP + Laravel, la base de datos MySql, la interfaz para consultas phpmyadmin y el sistema para emular el envío de correos con mailhog.

```bash
docker compose up -d --build
```

### 4. Acceder al contenedor de la aplicación

```bash
docker compose exec api_biblioteca-app bash
```

### 5. Instalar dependencias del proyecto

Ejecuta este comando dentro de la terminal del contenedor

```bash
composer install
```

### 6. Generar clave de aplicación

Ejecuta este comando dentro de la terminal del contenedor

```bash
php artisan key:generate
```

### 7. Migrar todas las tablas

Ejecuta este comando dentro de la terminal del contenedor

```bash
php artisan migrate:all
```

### 8. Generar la documentación del proyecto

Ejecuta este comando dentro de la terminal del contenedor

```bash
php artisan scribe:generate
```

### 9. Levantar el servidor, como es un entorno local y se debe acceder fuera del contenedor, se define este host

Ejecuta este comando dentro de la terminal del contenedor

```bash
php artisan ser --host=0.0.0.0
```

### 10. Rutas de acceso a las distintas interfaces

PHPMyAdmin: http://localhost:8080
Mailhog (email testing): http://localhost:8025
Documentación API: http://localhost:8000/docs

### 11. Por medio de Postman u otra interfaz para realizar peticiones ya se podrán ejecutar las siguientes peticiones:

Las siguientes rutas tendrán acceso sin necesidad de autenticación

POST    | http://localhost:8000/api/register    | Registro de usuario, en su respuesta ofrece el token de acceso
```json
{
  "name": "___",
  "surname": "___",
  "email": "___@___.com",
  "password": "12345678", // 8 dígitos
  "password_confirmation": "12345678", // 8 dígitos
  "role": "directivo" // bibliotecario o directivo
}
```

POST    | http://localhost:8000/api/login       | Identificación de usuario, en su respuesta ofrece el token de acceso
```json
{
  "email": "___@___.com",
  "password": "________"
}
```

GET     | http://localhost:8000/api/authors         | Obtener todos los autores

GET     | http://localhost:8000/api/authors/{id}    | Obtener un autor

GET     | http://localhost:8000/api/books           | Obtener todos los libros

GET     | http://localhost:8000/api/books/{id}      | Obtener un libro

Las siguientes rutas requieren del Headers: Authorization Bearer _______________________
Estas las proporcionan los métodos register y login, devolviendo los datos del usuario y el token de acceso

POST    | http://localhost:8000/api/logout          | Eliminar el token del usuario

GET     | http://localhost:8000/api/user            | Obtener datos de un usuario

POST    | http://localhost:8000/api/authors         | Crear autor
```json
{
  "library_author_name": "___",
  "library_author_birthdate": "0000-00-00",
  "library_author_biography": "___",
  "library_author_books": ["library_book_ids"] // Establecer este campo si se quiere sincornizar con el autor sus libros
}
```

PUT     | http://localhost:8000/api/authors/{id}    | Actualizar datos del autor
```json
{
  "library_author_name": "___",
  "library_author_birthdate": "0000-00-00",
  "library_author_biography": "___",
  "library_author_books": ["library_book_ids"] // Establecer este campo si se quiere sincornizar con el autor sus libros
}
```

DEL     | http://localhost:8000/api/authors/{id}    | Eliminar el autor

POST    | http://localhost:8000/api/books           | Crear libro
```json
{
  "library_book_title": "___",
  "library_book_description": "___",
  "library_book_published_year": 0000,
  "library_book_authors": ["library_author_ids"] // Establecer este campo si se quiere sincornizar con el libro sus autores
}
```

PUT     | http://localhost:8000/api/books/{id}      | Actualizar datos del libro
```json
{
  "library_book_title": "___",
  "library_book_description": "___",
  "library_book_published_year": 0000,
  "library_book_authors": ["library_author_ids"] // Establecer este campo si se quiere sincornizar con el libro sus autores
}
```

DEL     | http://localhost:8000/api/books/{id}      | Eliminar el libro

GET     | http://localhost:8000/api/export          | Exportar resumen para los directores
