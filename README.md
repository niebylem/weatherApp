# Weather forecast

Project using Open Weather Map API made up in educational purposes.

## Getting Started
### Prerequisites
Application needs an server with PHP, MySql database and Composer to run.

To configure it, edit .env file and set proper DB credentials:
```
DATABASE_URL=mysql://db_user:db_password@localhost:3306/db_name
``` 
Also, if available, put your Open Weather Map API KEY. Example key is already set up.
```
OPEN_WEATHER_MAP_API_KEY=YOUR_KEY
```

### Installing
To run app, proceed to its main directory in terminal and first of all install dependencies:
```
composer install
```

Then create database (with name provided in .env file)
```
php bin/console doctrine:database:create
```

To migrate application tables structure run:
```
php bin/console doctrine:migrations:migrate
```

That's it! Application is ready to use.