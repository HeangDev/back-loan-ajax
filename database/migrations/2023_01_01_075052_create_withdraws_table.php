<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('withdraws', function (Blueprint $table) {
            $table->id();
            $table->integer('id_customer');
            $table->integer('id_deposit');
            $table->float('withdraw_amount', 10, 2)->default('0');
            $table->float('after_amount', 10, 2)->default('0');
            $table->string('withdraw_code')->nullable()->default('0000');
            $table->date('withdraw_date');
            $table->string('status');
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
        Schema::dropIfExists('withdraws');
    }
};
