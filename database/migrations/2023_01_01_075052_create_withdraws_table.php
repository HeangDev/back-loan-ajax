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
            $table->integer('id_admin')->nullable();
            $table->integer('id_customer');
            $table->float('withdraw_amount', 10, 2)->default('0');
            $table->float('after_amount', 10, 2)->default('0');
            $table->date('withdraw_date');
            $table->string('status');
            $table->enum('confirm', ['0', '1'])->default('0');
            $table->enum('with_approved', ['no', 'yes'])->default('no');
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
