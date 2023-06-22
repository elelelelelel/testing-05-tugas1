<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSimilarityOrcidToUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->double('similarity')->after('balance')->default(0);
            $table->timestamp('reviewer_approved_at')->after('similarity')->nullable();
            $table->timestamp('reviewer_declined_at')->after('reviewer_approved_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['similarity', 'reviewer_approved_at', 'reviewer_declined_at']);
        });
    }
}
