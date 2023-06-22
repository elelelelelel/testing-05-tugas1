<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRateToOrders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->timestamp('upload_review_at')->after('confirmed_at')->nullable();
            $table->timestamp('revision_at')->after('upload_review_at')->nullable();
            $table->timestamp('done_at')->after('revision_at')->nullable();
            $table->string('testimonial')->nullable()->after('payment_proof');
            $table->double('rate')->after('testimonial')->default(0);
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
            $table->dropColumn(['testimonial', 'rate', 'revision_at', 'done_at', 'upload_review_at']);
        });
    }
}
