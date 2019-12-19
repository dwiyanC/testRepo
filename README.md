
## How To Run

You can reproduce this repo by following these steps:

- Clone or download this repo
- Move cloned repo to your preferred directory
- cd to that directory
- run composer install and wait for the process to finish
- Create your database
- Copy `.env.example` file and rename it into `.env`
- Add your database name and db credential into newly created `.env` file
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
- Run `php artisan storage:link` to show item image