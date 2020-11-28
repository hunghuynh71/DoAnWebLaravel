<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ves', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('gia')->unsigned();
            $table->integer('lich_chieu')->unsigned();
            $table->integer('ghe')->unsigned();
            $table->integer('ds_ve')->unsigned();
            $table->boolean('da_xoa')->default(false);
            $table->timestamps();

            $table->foreign('gia')->references('id')->on('gia_ves');
            $table->foreign('lich_chieu')->references('id')->on('lich_chieus');
            $table->foreign('ds_ve')->references('id')->on('ds_ves');
            $table->foreign('ghe')->references('id')->on('ghes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ves');
    }
}
