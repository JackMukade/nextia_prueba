Prueba para NEXTIA utilizando JWT utilizando Laravel 9

Casos de uso.
Desarrollar un API Rest con la ayuda de algún Framework PHP. Respuestas y envío de
información mediante JSON.
1. Crear proyecto y configuración.

R= Se utilizo la version de Laravel 9

___________________________________________

2. Crear un Modelo “Base” del cual heredarán los demás modelos que creemos en nuestro
proyecto. Este Modelo “Base” contendrá los siguientes campos
a. id = primary key
b. created_at = Tipo fecha, que se guarde automáticamente al crear un registro
c. updated_at = Tipo fecha, este se actualizará siempre que se actualice un
registro.

R= En la carpeta de app/Models se encuentran los archivos BaseModel.php, BienesModel.php, UserModel.php siendo el ejemplo
de una herencia, pero con Laravel no es necesario realizar estos procedimientos al utilizar el ORM (Object-Relational Mapping) es posible crear la base de datos desde el proyecto (Migrations) una vez creada las tablas desde el proyecto es facil crear los modelos relacionados con la base de datos (Bienes.php, User.php) son los modelos utilizados principalmente
para esta aplicación y con las variables creadas segun la base de datos.
___________________________________________

3. Generar un modelo para usuarios (que herede de BaseModel), NOTA. este modelo se
utilizará también para el proceso de autenticación, los datos que almacenará dicho
modelo son los siguientes.
a. Nombre
b. Usuario
c. Contraseña (Guardarla encriptada)

R= El modelo utilizado se encuentra en la carpeta app/Models/User.php y la tabla fue fecha con el archivo que se encuentra
en database/migrations/2014_10_12_000000_create_users_table.php

___________________________________________

4. Realizar endpoints y lógica para la autenticación de usuarios, se tendrá que hacer bajo el
estándar JWT.
a. Endpoint para generar JWT en base a usuario y contraseña.
b. Endpoint para crear usuario y crear JWT al momento de que se registre el
usuario.

R= en el archivo que se encuentra en routes/api.php se puede ver los endpoint utilizados para trabajar con jwt

'api/users/create'  se guarda el usuario y te devuelve tu endpoint

'api/users/login'   entra en sesión el usuario y permite utilizar los otros endpoint con el token
    
'api/users/logout'  cierra la sesion

'api/users/refresh' devuelve otro token

___________________________________________

5. Crear un modelo llamado Bienes (que herede de BaseModel). Los datos que almacenará
son los siguientes.
a. articulo = Tipo string, max 255
b. descripcion = Tipo string, max 255
c. usuario_id = Relación a modelo Usuario.

R= El modelo utilizado se encuentra en la carpeta app/Models/Bienes.php y la tabla fue fecha con el archivo que se encuentra
en database/migrations/2022_11_05_041546_create_bienes_table.php

___________________________________________

6. Crear un script el cual registre un usuario en la base de datos (Esto por que el Modelo
Bien requiere de un usuario existente), seguido de esto se te compartió un archivo csv
con ayuda de la librería fgetcsv o algúna de tu preferencia importar toda la información
de ese archivo a la base de datos al modelo Bienes, el id del usuario registrado
previamente se tendrá que almacenar en cada registro.

Para crear un usuario es posible utilizar el endpoint de 
'api/users/create' utilizando los inputs de name, email y password en un POST

y si te logueas es posible utilizar el endpoint :
'api/bienes/files' este comienza a leer el archivo que me mandaron que se encuentra guardado en el proyecto,
la logica se encuentra en el controlador BienesController.php que se encuentra en la carpeta app/Http/Controllers
siendo la funcion filescsv

___________________________________________
7. Crear endpoints CRUD para el modelo Bienes. Es importante que al regresar la
información siempre regrese el objeto usuario. Importante: Todos los endpoints tienen
que tener seguridad JWT.

Los endpoints para poder utilizar el CRUD para bienes, todo se encuentra en el controlador 
BienesController.php que se encuentra en la carpeta app/Http/Controllers se utilizo los terminos de 
API RESTful para poder hacer las llamadas

Create: api/bienes/create    

Read: api/bienes/read/{id}    

Update: api/bienes/update

Delete: api/bienes/delete

todos estos estan protegidos con un middleware que lee la informacion antes de que entre a los controladores para detectar
el JWT, en caso de no estar logueado te regresa al apartado de Login.

___________________________________________
8. Crear un endpoint especial para Bienes al cual se le puedan enviar múltiples id’s y este
me regrese un array de los registros solicitados.

api/bienes/filter/{id}

es parecido al read solo que los ids deben de estar dividos por , esto permitira hacer busqueda de varios ids

ejemplos: 
api/bienes/filter/100,101,102,103

EXTRA:

Debido a que ya se esta trabajando con Laravel ya se cuenta con una estructura MVC aunque en este caso solo se esta 
usando la parte del Modelo y el Controlador otro punto importate es que uso un poco la arquitectura SOLID 
separando los archivos para crear funciones que tengan una unica funcion por eso se creo la carpeta de Repositories
App/Repositories  es donde se crearon los archivos para interactuar con la base de datos utilizando ELOQUENT que es parte de Laravel para manipular las base de datos 