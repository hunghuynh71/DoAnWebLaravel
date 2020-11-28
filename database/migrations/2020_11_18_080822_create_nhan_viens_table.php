<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNhanViensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nhan_viens', function (Blueprint $table) {
            $table->increments('id');
            $table->string('ten_nv');
            $table->string('cmnd');
            $table->string('sdt');
            $table->string('email')->unique();
            $table->string('mat_khau');
            $table->date('ngay_vao_lam');
            $table->boolean('gioi_tinh')->default(true);
            $table->string('dia_chi');
            $table->boolean('dang_lam')->default(true);
            $table->integer('quyen')->unsigned();
            $table->boolean('da_xoa')->default(false);
            $table->timestamps();

            $table->foreign('quyen')->references('id')->on('quyens');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('nhan_viens');
    }
}
