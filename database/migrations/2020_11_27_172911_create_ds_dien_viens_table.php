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
            $table->integer('id')->default(1);
            $table->integer('phim')->unsigned();
            $table->integer('dien_vien')->unsigned();
            $table->primary(array('id','phim','dien_vien'));
            $table->increments('id')->change();
            $table->timestamps();

            $table->foreign('phim')->references('id')->on('phims');
            $table->foreign('dien_vien')->references('id')->on('dien_viens');
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
