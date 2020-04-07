### Friend API

[API documentation URL](http://localhost/api/documentation)

#### Initial launch of the project
##### Step 1.   
Cloning repository to the server. We need to SSH into our server, navigate to the folder prepared for the project, and launch git clone command.  
##### Step 2. .env file.  
1.Copy that example file as our main .env file with this command:
```
$ cp .env.example .env
```
2.Edit that new .env file, with Linux editors like Vim:
```
$ vi .env
```

- Set Application Name `APP_NAME`.  

*This value is the name of your application. This value is used when the
framework needs to place the application's name in a notification or
any other location as required by the application or its packages.*  

- Set Application Environment `APP_ENV`.

*This value determines the "environment" your application is currently
running in. This may determine how you prefer to configure various
services the application utilizes. Set this in your ".env" file.*

- Set Application Debug Mode `APP_DEBUG`.

*When your application is in debug mode, detailed error messages with
stack traces will be shown on every error that occurs within your
application. If disabled, a simple generic error page is shown.*

- Set application log level `LOG_LEVEL` and log channel `LOG_CHANNEL`  
[Laravel Logging](https://laravel.com/docs/6.x/logging#building-log-stacks)

- Set Application URL `APP_URL`.

*This URL is used by the console to properly generate URLs when using
the Artisan command line tool. You should set this to the root of
your application so that it is used when running Artisan tasks.*

- Set Database connection config and credentials
```
DB_CONNECTION=
DB_HOST=
DB_PORT=
DB_DATABASE=
DB_USERNAME=
DB_PASSWORD=
```
[Laravel documentation for configuring database](https://laravel.com/docs/7.x/database)

- Set host to show base URL of API server in API documentation
```
L5_SWAGGER_CONST_HOST=http://localhost/api/v1
```

##### Step 3. Preparation

Run first iteration of Docker environment

    docker-compose up -d

##### Step 4. Install all required components

I assume that there are no development tools on your computer, so you
need to login to Laravel container:

    docker-compose exec php bash

Install all dependencies

    composer install
    
Create database and seed tables

    php artisan key:generate
    php artisan migrate
    php artisan db:seed
    
Create new User
    
    php artisan make:user     

Fix write permissions on a few important folders

    chown apache:apache bootstrap/ -R
    chown apache:apache storage/ -R
    
##### Step 5. Install laravel passport. 
Run following command:
```
$ php artisan passport:install
```
Copy password grant `Client ID` and `Client secret` to `CLIENT_ID` and `CLIENT_SECRET` env variables

    
##### Step 6. Run test
    vendor/bin/phpunit
    
##### Step 7. Generate api documentation
```
$ php artisan l5-swagger:generate
```
[Laravel package for generating API documentation](https://github.com/DarkaOnLine/L5-Swagger)

### Steps after pull new changes
- Update .env if needed
- Run following commands:
```
$ composer install
$ php artisan migrate
$ php artisan l5-swagger:generate 
```
- Run commands for clear cache (for `APP_ENV=production`)
```
$ php artisan cache:clear
$ php artisan config:clear
```
