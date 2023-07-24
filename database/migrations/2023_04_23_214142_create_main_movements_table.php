<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMainMovementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('main_movements', function (Blueprint $table) {
            $table->id();
            $table->integer('source_location');
            $table->integer('destination_location');
            $table->integer('added_by');
            $table->date('date');
            $table->integer('status');
            $table->integer('staff');
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
        Schema::dropIfExists('main_movements');
    }
}
