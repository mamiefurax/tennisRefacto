tennisRefacto
=============

A Symfony project created on February 8, 2016, 6:12 pm.

Introduction
============
This is a symfony 3 refactoring exercice around a fabulous tennis match

Getting Start
=============
* Create an empty .env file
* install dependencies :
```
docker-compose run php composer install
```

* launch web stack thanks to docker :
```
docker-compose up -d
```
* access the site from you favorite browser : http://192.168.99.100:1337/app_dev.php/

Run Tests
=============
* Unit tests (phpunit)
```
docker-compose run php vendor/bin/phpunit -c phpunit.xml.dist
```