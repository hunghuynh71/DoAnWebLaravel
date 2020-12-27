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
            $table->integer('gia_id')->unsigned();
            $table->integer('lich_chieu_id')->unsigned();
            $table->integer('ghe_id')->unsigned();
            $table->integer('ds_ve_id')->unsigned();
            $table->unique(['lich_chieu_id','ghe_id','ds_ve_id']);
            $table->boolean('da_xoa')->default(false);
            $table->timestamps();

            $table->foreign('gia_id')->references('id')->on('gia_ves');
            $table->foreign('lich_chieu_id')->references('id')->on('lich_chieus');
            $table->foreign('ds_ve_id')->references('id')->on('ds_ves');
            $table->foreign('ghe_id')->references('id')->on('ghes');
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
