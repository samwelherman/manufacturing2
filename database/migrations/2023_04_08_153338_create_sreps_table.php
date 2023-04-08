<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSrepsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('screps', function (Blueprint $table) {
            $table->id();
            $table->integer('work_order_id');
            $table->integer('added_by');
            $table->integer('responsible_person')->nullable();
            $table->double('quantity');
            $table->double('balance')->nullable();
            $table->double('wasted')->nullable();
            $table->string('shift');
            $table->string('status')->nullable();;
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
        Schema::dropIfExists('screps');
    }
}
