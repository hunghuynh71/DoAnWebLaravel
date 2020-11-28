<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLichChieusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lich_chieus', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('phim')->unsigned();
            $table->integer('khung_tg_chieu')->unsigned();
            $table->integer('rap')->unsigned();
            $table->integer('nv_lap')->unsigned();
            $table->boolean('da_xoa')->default(false);
            $table->timestamps();

            $table->foreign('phim')->references('id')->on('phims');
            $table->foreign('khung_tg_chieu')->references('id')->on('khung_t_g_chieus');
            $table->foreign('nv_lap')->references('id')->on('nhan_viens');
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
        Schema::dropIfExists('lich_chieus');
    }
}
