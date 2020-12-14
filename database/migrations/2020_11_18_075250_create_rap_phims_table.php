<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRapPhimsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rap_phims', function (Blueprint $table) {
            $table->increments('id');
            $table->string('ten_rap');
            $table->integer('chi_nhanh_id')->unsigned();
            $table->integer('so_ghe');
            $table->boolean('da_xoa')->default(false);
            $table->timestamps();

            $table->foreign('chi_nhanh_id')->references('id')->on('chi_nhanhs');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rap_phims');
    }
}
