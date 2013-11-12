# CMSLite
CMSLite is a smimple content managment project using PHP and MySQL. It is a product of the merge between [Lynda.com's PHP with MySQL Essential Training](http://www.lynda.com/MySQL-tutorials/PHP-MySQL-Essential-Training/119003-2.html) and [Bootstrap](http://getbootstrap.com/) It's functionality expands to doing CRUD for pages and admins, login authentication, public and admin areas. Big credit to [Kevin Skoglund] (http://www.kevinskoglund.com/).

Please note that this is a very early version and I will expand on it.

## Features
* Public and admin area
* Page creation, edit and deletion
* Categorization of pages under subjects
* Admin creation, edit and deletion
* Admin authentication with password hashing

## Requirements
You will need a db on your server and you will have to edit the includes/db_connection.php file to your settings.

## To do
* Bug fixing (for some reason username won't be there if for example you mistook your password during login).
* Extended admin panel functionality: edit site title, edit further edit content, admin roles, maybe even change Bootstrap themes.
* Find a way to install/setup default user.
* Two password inputs instead of one (re-type your password).
* Further validations.
* A whole bunch of other things.

##PHP 5.5 Hashing: 
One can update password hashing to PHP 5.5 standards by switching the password_encrypt() and password_check functions() to the newly integrated password_hash() and password_verify(). I decided to keep the 5.4 custom functions for backwards compatibility. Alternatively you can use the [password_compat](https://github.com/ircmaxell/password_compat) library

###Remember:
Whatever you change always encrypt the user's password to prevent Internet vulnerability.
