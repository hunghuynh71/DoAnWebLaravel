<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGiaVesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gia_ves', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('loai_ghe')->unsigned();
            $table->integer('dinh_dang')->unsigned();
            $table->integer('khung_tg_chieu')->unsigned();
            $table->unique(['loai_ghe','dinh_dang','khung_tg_chieu']);
            $table->double('gia');
            $table->boolean('da_xoa')->default(false);
            $table->timestamps();

            $table->foreign('loai_ghe')->references('id')->on('loai_ghes');
            $table->foreign('dinh_dang')->references('id')->on('dinh_dangs');
            $table->foreign('khung_tg_chieu')->references('id')->on('khung_t_g_chieus');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('gia_ves');
    }
}
