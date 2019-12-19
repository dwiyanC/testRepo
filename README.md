
## How To Run

You can reproduce this repo in following step:

- Clone or download this repo
- Move cloned repo to your preferred directory
- cd to that directory
- run 'composer install' and wait for the process to finish
- Create your database
- Create your '.env' file by copying '.env.example'
- Add your database name and db credential into newly created '.env' file
- run migration using
'''
php artisan migrate
'''

- Make sure these tables show up in your database along with default laravel migration:
'''
    - users
    - inventories
    - item_comments
    - categories
    - item_images
'''
- run seeder by running 'php artisan db:seed' it will create 20 instances in users, inventories, and item_comments
- Access localhost and login with generated credential (you should check it in phpmyadmin, the default password is: password)
- For Admin access, change user role in user table to admin by accessing table directly
