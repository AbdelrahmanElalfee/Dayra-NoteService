# Getting started

## Installation

Clone the repository

    git clone https://github.com/AbdelrahmanElalfee/Dayra-NoteService.git

Switch to the repository folder

    cd Dayra-NoteService

Install all the dependencies using composer

    composer install

Copy the example .env file and make the required configuration changes in the .env file

    cp .env.example .env

Generate a new application key to be updated at the .env file

    php artisan key:generate

Set the database connection in .env file

    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=your_port
    DB_DATABASE=your_database
    DB_USERNAME=your_username
    DB_PASSWORD=your_password

Run MySQL docker image

    docker compose up
    // or
    docker compose up -d

Run the database migrations

    php artisan migrate

Start the local development server

    php artisan serve

You can now access the server at http://localhost:8000

Set Rabbitmq connection in .env file

    RABBITMQ_HOST=
    RABBITMQ_PORT=5672
    RABBITMQ_USER=
    RABBITMQ_PASSWORD=
    RABBITMQ_VHOST=

Run the queues

    php artisan queue:work

----------

# Code overview

## Dependencies

- [laravel-queue-rabbitmq](https://github.com/vyuldashev/laravel-queue-rabbitmq) - For message broker using RabbitMQ

## Folders

- `app/Models` - Contains all the Eloquent models
- `app/Helpers` - Contains all the helper methods
- `app/Jobs` - Contains all the jobs files
- `app/Http/Controllers` - Contains all the api controllers
- `app/Http/Middleware` - Contains the JWT auth middleware
- `app/Http/Requests` - Contains all the form requests
- `app/Http/Resources` - Contains all the resource files
- `app/Http/Exception` - Contains all the exception files
- `app/Repositories` - Contains all the repositories files
- `app/Traits` - Contains all the traits files
- `config` - Contains all the application configuration files
- `database/factories` - Contains the model factory for all the models
- `database/migrations` - Contains all the database migrations
- `routes` - Contains all the api routes defined in api.php file
- `tests` - Contains all the application tests

## Environment variables

- `.env` - Environment variables can be set in this file

***Note*** : You can quickly set the database information and other variables in this file and have the application fully working.

----------

# Testing API

Run the laravel development server

    php artisan serve

The api can now be accessed at

    http://localhost:8000/api

Request headers

| **Required** 	 | **Key**              	 | **Value**            	 |
|----------------|------------------------|------------------------|
| Yes      	     | Content-Type     	     | application/json 	     |
| Yes 	          | Authorization    	     | Bearer {JWT}      	    |

----------

# Authentication

These application use sessions and internal api calls to handle authentication.
The token is passed with each request using the `Authorization` header with `Token` scheme.
The Verify JWT Token middleware handles the validation and authentication of the token by making an internal api call
to the User Management Service.
Please check the following sources to learn more about JWT.

- https://jwt.io/introduction/
- https://self-issued.info/docs/draft-ietf-oauth-json-web-token.html
