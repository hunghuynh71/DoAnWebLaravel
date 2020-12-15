<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDsDienViensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ds_dien_viens', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('phim_id')->unsigned();
            $table->integer('dien_vien_id')->unsigned();
            $table->unique(array('phim_id','dien_vien_id'));
            $table->boolean('da_xoa')->default(0);
            $table->timestamps();

            $table->foreign('phim_id')->references('id')->on('phims');
            $table->foreign('dien_vien_id')->references('id')->on('dien_viens');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ds_dien_viens');
    }
}
