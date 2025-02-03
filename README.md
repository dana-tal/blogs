Introduction
============
A website where each user can manage multiple blogs. For each blog, articles can be created and managed. 
The articles are categorized by categories or keywords. Articles can be searched by keywords or categories.
Registered users can comment on existing articles. An admin user can also manage categories and keywords.
The website pulls content articles by connecting to an API (https://newsapi.org).
The site was developed using Laravel 11, MySQL, jQuery, and Tailwind CSS. Special attention was given to securing sensitive routes.
You can register or log in with the following credentials to explore the system:
Email: test@gmail.com
Password: 123456
The application has been deployed on an Amazon server.
Demo:  Blogs system demo

Github: Blogs github link


How to install
==============
1)	sudo git clone https://github.com/dana-tal/blogs.git
2)	sudo chown ubuntu:ubuntu –R blogs
3)	cd blogs
4)	sudo chown www-data:www-data –R storage
5)	sudo chmod -R ugo+rw storage
6)	create .env file (by coppying .env.example)  :  sudo nano .env, focus on the following parameters:
APP_URL	Your domain or virtual domain like : http://blogs.test
DB_CONNECTION	mysql
DB_HOST	db host like  127.0.0.1
DB_PORT	3306
DB_DATABASE	database name
DB_USERNAME	username
DB_PASSWORD	password 
ADMIN_PASS	The admin user password
TEST_PASS 	The test user password
API_KEY	Register here: https://newsapi.org/,
get your api key and assign its value here 

7)	update laravel packages by running :  composer update 
8)	sudo php  artisan key:generate 
9)	 Run: php artisan migrate:fresh  to create the database 
10)	 Run: php artisan db:seed – to seed the database 
11)	  npm install
12)	  npm update
13)	  npm build 

