<?php

use Illuminate\Database\Seeder;
use App\Inventory2;
use App\Comment2;

class InventoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Inventory2::class, 20)->create()->each(function($u) {
            $u->comments()->save(factory(App\Comment2::class)->make());
          });
    }
}
