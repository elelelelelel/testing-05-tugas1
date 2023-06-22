<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFormReviewToOrders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->text('form_review_path')->nullable()->after('file_path');
            $table->text('form_review_name')->nullable()->after('form_review_path');
            $table->text('form_review_size')->nullable()->after('form_review_name');
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
            $table->dropColumn(['form_review_path', 'form_review_name', 'form_review_size']);
        });
    }
}
