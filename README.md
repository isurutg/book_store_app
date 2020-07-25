# My Book Store App

## Requirements

```
php 7+
composer
node 10+
yarn
```

## Run application in your local environment

* Clone git repository
````
git clone https://github.com/isurutg/book_store_app.git
````

* go to the project directory
```$xslt
cd book_store_app
```

* run `composer install`

* run `yarn install`

* update .env file with your db credentials
```$xslt
nano .env

..
32 DATABASE_URL=mysql://**$DB_USER**:**$DB_PASSWORD**@**$DB_HOST**:**$DB_PORT**/book_store_app?serverVersion=8.0
..
```

* create database
```
 php bin/console doctrine:database:create
```

* run migrations
```$xslt
 php bin/console doctrine:migrations:migrate
```

* run database seeding
```$xslt
php bin/console doctrine:fixtures:load
```

* generate css and js
```$xslt
yarn encore dev
```

* run inbuilt server in symfony
```$xslt
symfony server:start
```

## About Application

now the  application is running on `localhost:8001`

* to add new books and coupons `localhost:8001/login` and log with username: `admin` password:`admin1234`

* sample coupon codes to enter on checkout
```$xslt
1234
abcd
abcd1234
```

## How to run unit test

On you console run following command run unit tests.
```$xslt
 php bin/phpunit
```

## This application is build upon following assumptions.

* Our store will only sell two types of books. ( Children, Fiction )
* Buyer can buy any amount from single book item.
* Discounts to the purchases is fixed.