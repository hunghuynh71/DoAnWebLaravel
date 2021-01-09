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
            $table->integer('loai_ghe_id')->unsigned();
            $table->integer('lich_chieu_id')->unsigned();
            $table->unique(['loai_ghe_id','lich_chieu_id']);
            $table->double('gia');
            $table->boolean('da_xoa')->default(false);
            $table->timestamps();
            
            $table->foreign('loai_ghe_id')->references('id')->on('loai_ghes');
            $table->foreign('lich_chieu_id')->references('id')->on('lich_chieus');
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
