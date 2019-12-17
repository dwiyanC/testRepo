<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemComments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item_comments', function (Blueprint $table) {
            $table->bigIncrements('comment_id');
            $table->bigInteger('inventory2_id')->unsigned();
            $table->foreign('inventory2_id')->references('id')->on('inventories')->onDelete('cascade');

        //     $table->integer('inventory2_id')->unsigned();
        //    // $table->foreign('inventory_id')->references('id')->on('inventories');
            $table->text('comment');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('item_comments');
    }
}
