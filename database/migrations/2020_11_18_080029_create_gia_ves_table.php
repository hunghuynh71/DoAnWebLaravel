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
            $table->integer('nhan_phim')->unsigned();
            $table->integer('khung_tg_chieu')->unsigned();
            $table->integer('gia');
            $table->boolean('da_xoa')->default(false);
            $table->timestamps();

            $table->foreign('loai_ghe')->references('id')->on('loai_ghes');
            $table->foreign('nhan_phim')->references('id')->on('nhan_phims');
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
