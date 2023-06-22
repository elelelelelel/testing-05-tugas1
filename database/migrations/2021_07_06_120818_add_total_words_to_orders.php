<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTotalWordsToOrders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->double('price')->default(0)->after('account_holder');
            $table->integer('total_words')->default(0)->after('price');
            $table->integer('rate_admin')->default(3)->after('rate');
            $table->dropForeign(['reviewer_id']);
            $table->bigInteger('reviewer_id')->nullable()->unsigned()->change();
            $table->foreign('reviewer_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            //
        });
    }
}
