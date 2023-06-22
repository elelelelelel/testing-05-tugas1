<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDeadlineAtToAuctionDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('auction_details', function (Blueprint $table) {
            $table->timestamp('deadline_at')->nullable()->after('bid');
            $table->dropColumn(['bid_description']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('auction_details', function (Blueprint $table) {
            $table->text('bid_description')->nullable()->after('bid');
            $table->dropColumn(['deadline_at']);
        });
    }
}
