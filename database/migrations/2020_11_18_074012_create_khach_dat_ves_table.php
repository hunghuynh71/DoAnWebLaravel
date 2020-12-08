<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKhachDatVesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('khach_dat_ves', function (Blueprint $table) {
            $table->increments('id');
            $table->string('ten_kdv');
            $table->string('sdt')->unique();
            $table->string('email')->unique();
            $table->string('mat_khau');
            $table->integer('nam_sinh');
            $table->boolean('gioi_tinh')->default(true);
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
        Schema::dropIfExists('khach_dat_ves');
    }
}
