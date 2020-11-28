<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGhesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ghes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('loai_ghe')->unsigned();
            $table->integer('rap')->unsigned();
            $table->integer('tinh_trang')->unsigned();
            $table->boolean('da_xoa')->default(false);
            $table->timestamps();

            $table->foreign('loai_ghe')->references('id')->on('loai_ghes');
            $table->foreign('rap')->references('id')->on('rap_phims');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ghes');
    }
}
