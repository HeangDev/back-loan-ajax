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
        Schema::create('loans', function (Blueprint $table) {
            $table->id();
            $table->integer('id_customer');
            $table->integer('id_duration')->nullable();
            $table->float('amount', 8, 2)->nullable()->default('0');
            $table->float('interest', 8, 2)->nullable()->default('0');
            $table->float('total', 8, 2)->nullable()->default('0');
            $table->float('pay_month', 8, 2)->nullable()->default('0');
            $table->date('date')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->enum('status', ['0', '1'])->default('0');
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
        Schema::dropIfExists('loans');
    }
};
