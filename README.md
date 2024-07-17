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

Fichero __db.php__:
Contiene los datos de conexión necesarios para acceder a la base de datos mysql.
Sustituir los existentes por los reales.

Fichero __config.ini__:
Contiene los datos de conexión necesarios para poder realizar los envíos de emails.
Sustituir los existentes por los reales.

Hay que seguir unos pasos para poder activar la cuenta xxxxx@gmail.com como emisora de los emails __(Falta documentar!)__
Una vez activo, insertar los datos en el fichero "config.ini"

Crear la base de datos cebancpractdb.

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


