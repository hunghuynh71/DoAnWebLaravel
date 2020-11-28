<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePhimsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('phims', function (Blueprint $table) {
            $table->increments('id');
            $table->string('ten_phim');
            $table->integer('dao_dien')->unsigned();
            $table->integer('the_loai')->unsigned();
            $table->string('hinh_anh');
            $table->string('nha_san_xuat');
            $table->string('quoc_gia');
            $table->date('ngay_xuat_ban');
            $table->integer('thoi_luong');
            $table->string('trailer');
            $table->integer('diem');
            $table->integer('nv_duyet')->unsigned();
            $table->boolean('da_xoa')->default(false);
            $table->timestamps();

            $table->foreign('dao_dien')->references('id')->on('dao_diens');
            $table->foreign('the_loai')->references('id')->on('the_loais');
            $table->foreign('nv_duyet')->references('id')->on('nhan_viens');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('phims');
    }
}
