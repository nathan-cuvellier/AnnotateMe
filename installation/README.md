# After installation by fork/clone

### Dependencies

* **Composer**
* **PHP**: >= 7.2
* **PostgreSQL**: >= 9.5


### Setup

> :warning: setup database in .env

```shell script
$ chmod +x installation/setup.sh
$ installation/setup.sh
$ cd laravel
$ php artisan migrate
```
# Optional
### Tests PHPUnit
If you want to check that the whole installation is done correctly, you can perform the tests in laravel directory, with the following command:

```shell script
$ vendor/phpunit/phpunit/phpunit
```