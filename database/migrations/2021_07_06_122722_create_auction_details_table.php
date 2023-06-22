<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuctionDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('auction_details', function (Blueprint $table) {
            $table->engine = 'ndbcluster';
            $table->bigIncrements('id');
            $table->bigInteger('auction_id')->unsigned();
            $table->foreign('auction_id')->references('id')->on('auctions')
                ->onDelete('cascade');
            $table->bigInteger('reviewer_id')->unsigned();
            $table->foreign('reviewer_id')->references('id')->on('users')
                ->onDelete('cascade');
            $table->double('bid');
            $table->string('bid_description');
            $table->tinyInteger('status')->default(0)->comment('0 tidak; 1 iya');
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
        Schema::dropIfExists('auction_details');
    }
}
