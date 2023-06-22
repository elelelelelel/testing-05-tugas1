<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePesanansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pesanans', function (Blueprint $table) {
            $table->id('id_nota');
            $table->string('atas_nama');
            $table->string('no_meja');
            $table->string('total_harga');
            $table->unsignedTinyInteger('isdone');
            $table->timestamps();
            $table->bigInteger('admin_id')->unsigned();
            $table->foreign('admin_id')->references('id_admin')->on('users')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pesanans');
    }
}
