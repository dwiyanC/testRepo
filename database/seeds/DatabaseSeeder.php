<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call(InventoriesTableSeeder::class);
        $this->call(CommentsTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        // $this->call(CategorySeeder::class);
        Model::reguard();
    }
}
