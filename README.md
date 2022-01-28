# Script
PHP based web application which is like Yemeksepeti

## Dependencies

If you are linux or mac user, you need to install LAMP Server. (Check [DigitialOcean Installation](https://www.digitalocean.com/community/tutorials/how-to-install-linux-apache-mysql-php-lamp-stack-ubuntu-18-04) out)

If you're using Windows, you need install a web server such as XAMPP, WAMP or AppServ.

After installation of LAMP, create database as defined in the `config.php`. Log in your mysql shell. Then follow the processes
```bash
CREATE USER 'admin'@'localhost' IDENTIFIED BY 'password';
GRANT ALL PRIVILEGES ON * . * TO 'admin'@'localhost';
FLUSH PRIVILEGES;
```
Database is created.

## Installation

To run this app in local: First, install the repository via `git clone`. Move project to the web server directory.

```bash
git clone https://github.com/arslanblcn/Script.git
```
and run `setup.php` to create application's tables. (You can visit the page on browser by navigating the localhost)
