<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->engine = 'ndbcluster';
            $table->bigIncrements('id');
            $table->bigInteger('editor_id')->unsigned();
            $table->foreign('editor_id')->references('id')->on('users');
            $table->bigInteger('reviewer_id')->unsigned();
            $table->foreign('reviewer_id')->references('id')->on('users');
            $table->bigInteger('price_id')->unsigned();
            $table->foreign('price_id')->references('id')->on('price_lists');
            $table->string('invoice');
            $table->text('title');
            $table->text('abstract');
            $table->string('keyword', 255);
            $table->string('file_path');
            $table->string('file_name');
            $table->string('file_size');
            $table->string('account_name');
            $table->string('account_number');
            $table->string('account_holder');
            $table->double('tax_price')->default(0);
            $table->double('total_price');
            $table->string('payment_proof')->nullable();
            $table->timestamp('payment_due')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->timestamp('confirmed_at')->nullable();
            $table->timestamp('declined_at')->nullable();
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
        Schema::dropIfExists('orders');
    }
}
