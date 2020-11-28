<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDaoDiensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dao_diens', function (Blueprint $table) {
            $table->increments('id');
            $table->string('ten_dd');
            $table->date('ngay_sinh');
            $table->float('chieu_cao');
            $table->string('quoc_gia');
            $table->string('tieu_su');
            $table->string('hinh_anh');
            $table->boolean('da_xoa')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dao_diens');
    }
}
