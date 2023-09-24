
## About This Project

This is a Transport Application. In this project, I use the Laravel framework. for authentication, I use Laravel Passport because Laravel Passport supports OAuth2. Here users can register and Login using API and calculate transport prices based on requirements.


## Project Setup
First, you need to clone this repository
```
git clone https://github.com/MonirHossen/transport-app.git
```
Then use this command
```
cd transport-app
```
Then run this command, here this ignore command is needed because I had some issues when I installed the passport package.
```
composer update --ignore-platform-req=ext-sodium
```
Then make a .env file on project root copy and paste the .env.example code, and change the DB name to the DB name that I provide 

Then run this command
```
php artisan key:generate
```

Then run this command
```
php artisan passport:install
```
Then run this command
```
php artisan migrate
```
Or you can use the DB that I provide

Then run this command
```
php artisan serve
```

Now you have to use Postman to check my APIs

I think now this project will be run on your local machine.
Thank You!


