# RELLE - Remote Labs Learning Environment

RELLE is a Remote Lab Management System developed using Laravel Framework, jQuery and Flat-UI front-end framework.

Requirements
- PHP >= 5.6.4
- MySQL
- Google Analytics Account
- Google OAuth API active, for analytics authentication in back-end
- Composer
- OpenSSL PHP Extension
- PDO PHP Extension
- Mbstring PHP Extension
- Tokenizer PHP Extension
- XML PHP Extension

### Installation

#### Laravel Installation

The first step is composer intallation, you can follow this guide for install [Composer](https://getcomposer.org/doc/00-intro.md#installation-linux-unix-osx).

The second step is clone this repository and rename ``.env.example`` to .``env`` and edit follow this example below.
```sh
APP_ENV=local
APP_DEBUG=true
APP_KEY=SomeRandomString

DB_HOST=localhost
DB_DATABASE=DatabaseName
DB_USERNAME=DatabaseUser
DB_PASSWORD=DatabasePass

CACHE_DRIVER=file
SESSION_DRIVER=database
QUEUE_DRIVER=sync

MAIL_DRIVER=smtp
MAIL_HOST=mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=null
MAIL_PASSWORD=null

ANALYTICS_PROVIDER=GoogleAnalytics
ANALYTICS_TRACKING_ID=UA-XXXXXXX-1
```

The first step is run composer to install dependencies inside the array ``require`` in ``composer.json`` follow this command.
```
composer install
```

Directories within the storage and the bootstrap/cache directories should be writable.

```
chmod -R 777 storage
chmod -R 777 bootstrap/cache
```

#### Create Database Creation

For create the database we need execute the command ```php artisan migrate``` the file which contains information about the tables was hosted on ```migrations``` path. Tables created, we will need configure ```database.php``` like on the ```.env``` database parameters. This file is reponsible to communicate application and database.

```
	'default' => 'mysql',

	'connections' => [

		'sqlite' => [
			'driver'   => 'sqlite',
			'database' => storage_path().'/database.sqlite',
			'prefix'   => '',
		],

		'mysql' => [
			'driver'    => 'mysql',
			'host'      => env('DB_HOST', 'yourDBHost'),
			'database'  => env('DB_DATABASE', 'databaseName'),
			'username'  => env('DB_USERNAME', 'databaseUser'),
			'password'  => env('DB_PASSWORD', 'databasePass'),
			'charset'   => 'utf8',
			'collation' => 'utf8_unicode_ci',
			'prefix'    => '',
			'strict'    => false,
		],
            
                'moodle' => [
			'driver'    => 'mysql',
			'host'      => env('DB_HOST', 'yourHost'),
			'database'  => 'moodleDatabaseName',
			'username'  => env('DB_USERNAME', 'databaseUser'),
			'password'  => env('DB_PASSWORD', 'databasePass'),
			'charset'   => 'utf8',
			'collation' => 'utf8_unicode_ci',
			'prefix'    => '',
			'strict'    => false,
		],
		
		....
```

In ```app/Helpers.php``` set database credentials for moodle on ```moodle_db()``` function. 
 
#### Google Analytics Configuration

The Google Analytics support is developed by ```"ipunkt/laravel-analytics"``` for send and ```"google/apiclient"``` to retrieve data.

- Send data
You can follow this [tutorial](https://github.com/ipunkt/laravel-analytics) to configure this plugin.

- Retrieve data
For retrieve data we need a back-end authentication, this [tutorial](https://developers.google.com/api-client-library/php/auth/web-app) or [this](https://github.com/google/google-api-php-client). For charts generation and logs you can the [official documentation](https://developers.google.com/analytics/devguides/reporting/embed/v1/) or see the file ```resources/views/pages/dashboard.blade.php``` that have examples of uses.

#### Web Server Configuration

You can follow this tutorial to check web server configuration hosted by [Laravel](https://laravel.com/docs/5.4#web-server-configuration).

- Sample of Apache configuration file ```relle.conf```.
```
<VirtualHost *:80>
	ProxyPreserveHost On
	RewriteEngine On
 
	ServerAdmin rexlabufsc@gmail.com
	ServerName relle.ufsc.br
	ServerAlias relle.ufsc.br
	DocumentRoot /var/www/relle/public
	
	<Directory "/var/www/relle/public">
		Order allow,deny
		Allow from all
		Require all granted
		AllowOverride All
		Options +Indexes +FollowSymLinks +MultiViews
	</Directory>

	ErrorLog ${APACHE_LOG_DIR}/error.log
	CustomLog ${APACHE_LOG_DIR}/access.log combined

</VirtualHost>
```

### Usage

A manual of usage was available in [RELLE Docs](http://relle.ufsc.br/docs).

### Conctact

- [Remote Experimentation Laboratory](http://rexlab.ufsc.br/)

License
----

MIT

