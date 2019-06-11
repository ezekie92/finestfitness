# Instrucciones de instalación y despliegue

## En local

### Requisitos
- PHP 7.1
- Postgresql 10.3
- Servidor Web
- Composer
- Git (opcional)
- Cuenta de AWS
- Cuenta de email

### Instalación

 1. Clonar el repositorio

    ~~~
    git clone [https://github.com/ezekie92/finestfitness.git](https://github.com/ezekie92/finestfitness.git)
    ~~~
    
 2. Instalar los paquetes de Composer desde el directorio raíz:

    ~~~
    composer install
    ~~~

 3. Crear la base de datos y cargar las tablas, también desde el
    directorio raíz:

    ~~~
    db/create.sh
	db/load.sh
    ~~~

 4. Crear un archivo .env en el directorio raíz que contenga las
    variables de entorno:

    ~~~
    SMTP_PASS con la clave de acceso de la dirección de correo
    PAYPAL con la clave de acceso de la cuenta de paypal
    BUCKET con el nombre del bucket de Amazon S3
    S3KEY con la clave referencial de Amazon S3
    S3SECRET con la clave secreta de Amazon S3
    ~~~

 5. Iniciar el servidor desde el directorio raíz usando:

    ~~~
    make serve
    ~~~

 6. Abrir un navegador y dirigirse a la url del servidor local:

    ~~~
    [http://localhost:8080](http://localhost:8080)
    ~~~

## En la nube

### Requisitos:

- Cuenta en Heroku
- Heroku CLI

### Instalación

 1. Crear una app en Heroku y añadir el add-on Heroku Postgres

 2. Ejecutar en el directorio raíz:

    ~~~
    heroku login
    heroku git:remote -a nombre_app_heroku
    git push heroku master
    heroku psql < db/finestfitness.sql
    heroku run "./yii migrate"
    ~~~

 3. Añadir a la app de Heroku las variables de entorno mencionadas en la
    instalación local, y una más, tal y como se muestra a continuación:
    YII_ENV=prod

La aplicación ya estaría funcionando en el link que nos proporciona Heroku.
