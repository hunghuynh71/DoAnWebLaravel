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
            $table->integer('phim_id')->unsigned();
            $table->integer('ktgc_id')->unsigned();
            $table->integer('rap_id')->unsigned();
            $table->integer('dinh_dang_id')->unsigned();
            $table->date('ngay_chieu');
            $table->unique(['ktgc_id','rap_id','ngay_chieu']);
            $table->integer('nv_lap_id')->unsigned();
            $table->boolean('da_xoa')->default(false);
            $table->timestamps();

            $table->foreign('phim_id')->references('id')->on('phims');
            $table->foreign('ktgc_id')->references('id')->on('khung_t_g_chieus');
            $table->foreign('nv_lap_id')->references('id')->on('nhan_viens');
            $table->foreign('rap_id')->references('id')->on('rap_phims');
            $table->foreign('dinh_dang_id')->references('id')->on('dinh_dangs');
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
