<?php

use Carbon\Traits\Date;
use Carbon\Traits\Timestamp;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDsVesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ds_ves', function (Blueprint $table) {
            $table->increments('id');
            $table->date('tg_dat');
            $table->integer('khach_dat_ve')->unsigned();
            $table->integer('chi_nhanh')->unsigned();
            $table->integer('sl_ve');
            $table->boolean('da_xoa')->default(false);
            $table->timestamps();

            $table->foreign('khach_dat_ve')->references('id')->on('khach_dat_ves');
            $table->foreign('chi_nhanh')->references('id')->on('chi_nhanhs');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ds_ves');
    }
}
