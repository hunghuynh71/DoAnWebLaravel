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
            $table->integer('loai_ghe_id')->unsigned();
            $table->integer('rap_id')->unsigned();
            $table->integer('tinh_trang')->default(0);
            $table->boolean('da_xoa')->default(false);
            $table->timestamps();

            $table->foreign('loai_ghe_id')->references('id')->on('loai_ghes');
            $table->foreign('rap_id')->references('id')->on('rap_phims');
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
