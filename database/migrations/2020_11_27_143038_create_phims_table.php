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
            $table->integer('dao_dien_id')->unsigned();
            $table->integer('the_loai_id')->unsigned();
            $table->string('ds_dien_vien');
            $table->string('hinh_anh');
            $table->string('nha_san_xuat');
            $table->string('quoc_gia');
            $table->date('ngay_xuat_ban');
            $table->integer('thoi_luong');
            $table->string('trailer');
            $table->string('nhan_phim');
            $table->string('mo_ta');
            $table->integer('diem')->default(0);
            $table->integer('nv_duyet_id')->unsigned();
            $table->boolean('da_xoa')->default(false);
            $table->timestamps();

            $table->foreign('dao_dien_id')->references('id')->on('dao_diens');
            $table->foreign('the_loai_id')->references('id')->on('the_loais');
            $table->foreign('nv_duyet_id')->references('id')->on('nhan_viens');
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
