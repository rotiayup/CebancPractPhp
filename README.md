# Crear proyecto php de prueba

Programa proyecto php de prueba.
Pasos a seguir para ponerlo en marcha:

Instalar Xampp.
Arrancar Apache y MySql.

Copiar la carpeta principal en la carpeta ../xampp/htdocs del servidor web.

Si no hemos copiado la carpeta /vendor/ asociada al proyecto, necesitaremos instalar las librerías necesarias para PDF y Mail:

composer require phpmailer/phpmailer

composer require dompdf/dompdf

Para poder acceder a la variables de entorno, necesitamos instalar:

composer require vlucas/phpdotenv

Y necesitaremos un fichero llamado __.env__ con las siguientes variables:
>DDBB_SERVERNAME=localhost (o servidor)  
>DDBB_USERNAME=xxxx  
>DDBB_PASSWORD=xxxx 
>DDBB_DBNAME=xxxxxx 
>EMAIL_HOST=smtp.gmail.com 
>EMAIL_FROM_EMAIL=xxxxxx@gmail.com
>EMAIL_FROM_NAME="Xxxxx Xxxxxx"
>EMAIL_PASSWORD=xxxxxxxx
>EMAIL_FROM_EMAIL2=xxxxxx@gmail.com
>EMAIL_FROM_NAME2="Xxxxx Xxxxxx"
>EMAIL_PORT=587

Sustiuir los valores por los reales de conexión.

Hay que seguir unos pasos para poder activar la cuenta xxxxx@gmail.com como emisora de los emails __(Falta documentar!)__
Una vez activo, insertar los datos en el fichero "config.ini"

Crear la base de datos xxxxxx.

Ejecutar el programa https://miservidor/create_table_user.php para crear la tabla users.

Ejecutar el programa https://miservidor/cebancpractdb y "registrar" una cuenta (alta en tabla users).

Entrar "login" con esa cuenta creada.

Ya dentro del menú: 
+ "Crear tablas": Esta opción crea las tablas clientes y pedidos necesarias para nuestra prueba, e inserta en ellas los datos de prueba.
+ Ejecutar "Mostrar datos", para ver los datos insertados.
+ "Crear PFD Pedido", creará una pdf en la carpeta ../pdf asociada al cliente que hayamos seleccionado.
+ "Enviar email con PFD", creará una pdf en la carpeta ../pdf como antes, y además enviará email a través de gmail al email asociado al cliente.

http://frogarotiayupinfinity2.42web.io/cebancpractphp2

[.](https://markdown-it.github.io/)


