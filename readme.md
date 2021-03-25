# BeautyBill

This package is build on TFPDF. 


# How to test this package?

For local testing you may want to use the 
enclosed docker file. First, get a the container running
using 

```
docker-compose up -d --build
```

Next, go inside the container to install composer and run phpunit: 

```
docker-compose exec app bash
composer install
php vendor/bin/phpunit
```