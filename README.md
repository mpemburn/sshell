# Secure Shell

Lavavel-based secure shell app that supports pre-define command sets.
## Requirements:
**Secure Shell** was created in **Laravel version 11.x** and requires the following:

* **PHP** >= 8.1
* **Composer** >= 2.5.5
* **npm** >= 9.7.2

## Installation:
Install **Secure Shell** locally with the following command:

`git clone git@github.com:mpemburn/sshell.git`

Change to the `sshell` directory and run:

`composer install`

...to install the PHP dependencies.

`npm install`

...to install modules needed to compile the JavaScript and CSS assets.

`npm run build`

...to do the asset compiling.

Copy `.env.example` to `.env` and add the credentials for your Mysql:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=sshell
DB_USERNAME=[username]
DB_PASSWORD=[password]
```
After creating the `sshell` database in Mysql, run migration to create the data tables:

`php artisan migrate`

You will need to run a web server to run **Secure Shell** in a browser.
I recommend [**Laravel Valet**](https://laravel.com/docs/10.x/valet), but you can do it simply by going to the project
directory and running:

`php artisan:serve`

This will launch a server on `http://127.0.0.1:8000`

## How to Use Secure Shell:

Once you have **Secure Shell** running in a browser, you first need
to create a user account by clicking on **Register** in the top
right corner.

