<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailPesanansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_pesanans', function (Blueprint $table) {
            $table->id('id_pesanan');
            $table->string('jumlah');
            $table->timestamps();
            $table->bigInteger('nota_id')->unsigned();
            $table->foreign('nota_id')->references('id_nota')->on('pesanans')
                ->onDelete('cascade');

            $table->bigInteger('produk_id')->unsigned();
            $table->foreign('produk_id')->references('id_produk')->on('produks')
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
        Schema::dropIfExists('detail_pesanans');
    }
}
