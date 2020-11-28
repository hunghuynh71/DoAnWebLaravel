<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBinhLuansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('binh_luans', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('phim')->unsigned();
            $table->integer('nguoi_binh_luan')->unsigned();
            $table->string('noi_dung');
            $table->boolean('da_xoa')->default(false);
            $table->timestamps();

            $table->foreign('phim')->references('id')->on('phims');
            $table->foreign('nguoi_binh_luan')->references('id')->on('khach_dat_ves');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('binh_luans');
    }
}
