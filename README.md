
## Install Prerequisites

- Composer
- Php 7.x
- Laravel (this project use Laravel 6.x)

## How To Run

You can reproduce this repo by following these steps:

- Clone or download this repo
    - To clone: `git clone https://github.com/dwiyanC/testRepo.git`
- Move cloned repo to your preferred directory
- Navigate to that directory in terminal, the command should be: `cd path/to/project/folder`
- run `composer install` in terminal and wait for the process to finish
- While you wait, create your database
- Copy `.env.example` file and rename new file into `.env`
- Put your database name and db credentials into newly created `.env` file.
- run `php artisan key:generate`
- run migration using `php artisan migrate`
- Make sure these tables show up in your database along with default laravel migration:

    - users
    - inventories
    - item_comments
    - categories
    - item_images

- run seeder by running `php artisan db:seed` it will create 20 instances in users, inventories, item_comments
- run category seeder by running `php artisan db:seed --class=CategorySeeder`, it will create 3 instances of Category
- run `php artisan serve` , and let the server run
- Access localhost and login with generated credential (you have to check it in phpmyadmin, the default password is: 123456)
- For Admin access, change user role in user table to admin by accessing table directly
- Run `php artisan storage:link` to show item image in details