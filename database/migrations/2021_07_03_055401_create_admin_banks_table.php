<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminBanksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_banks', function (Blueprint $table) {
            $table->engine = 'ndbcluster';
            $table->bigIncrements('id');
            $table->string('bank_name');
            $table->string('bank_number');
            $table->string('bank_holder');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admin_banks');
    }
}
