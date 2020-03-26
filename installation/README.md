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

# Install AnnotateMe from blank iso (ubuntu)

- **Update**
`$ sudo apt-get update && sudo apt-gett upgrade -y`

- **Install** apache2
`$ sudo apt-get install apache2`

- **Install** PHP7.2
`$ sudo apt-get install apache2 php7.2 php7.2-{common,bcmath,bz2,intl,gd,mbstring,mysql,zip,pgsql} libapache2-mod-php`

- **Enable** rewrite
`$ sudo a2enmod rewrite`
- **Install** GIT
`$ sudo apt-get install git`
- **Install** PostgreSQL
`$ sudo apt-get install postgresql`

:warning: If you put the web site in production, don't use the default user for the security
- Connect to user postgres
`$ sudo -u postgres psql`
- Change password for postgres user
`$ \password postgres`
- **Install** phppgadmin
`$ apt-get install phppgadmin`
- **Install** Composer
[getcomposer.org/download/](https://getcomposer.org/download/)


### Edit the phpPgAdmin configuration file (/etc/phppgadmin/config.inc.php) and replace:
```conf
$conf['extra_login_security'] = true;
```
with:
```
$conf['extra_login_security'] = false;
```

### Change configuration of apache2

Edit the config file :
```sh
$ nano /etc/apache2/site-available/000-default.conf
```
Example of configuration :
```
DocumentRoot /var/www/AnnotateMe/laravel/public

<Directory /var/www/AnnotateMe>
	Options Indexes FollowSymLinks MultiViews
	AllowOverride All
	Order allow,deny
	allow from all
</Directory>
```
### Install web site
```
$ cd /var/www
$ git clone origin https://github.com/AnnotateMe/AnnotateMe.git
$ cd AnnotateMe
$ chmod +x installation/setup.sh
$ ./installation/setup.sh
```

### :warning: Create database before this commande and change information in .env file in laravel folder
```
$ cd laravel
$ php artisan migrate
```
# Optional

### Tests PHPUnit

If you want to check that the whole installation is done correctly, you can perform the tests in laravel directory, with the following command :

  

```sh
$ vendor/phpunit/phpunit/phpunit
```
