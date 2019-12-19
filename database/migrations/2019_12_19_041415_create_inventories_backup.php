<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInventoriesBackup extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventories_backup', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('unit_type');
            $table->string('unit_name');
            $table->string('unit_no');
            $table->tinyInteger('active')->default('1');
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
        Schema::dropIfExists('inventories_backup');
    }
}
