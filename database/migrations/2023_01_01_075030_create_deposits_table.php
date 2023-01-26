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
        Schema::create('deposits', function (Blueprint $table) {
            $table->id();
            $table->integer('id_admin')->nullable();
            $table->integer('id_customer');
            $table->float('deposit_amount', 10, 2)->nullable()->default('0');
            $table->text('description')->nullable()->default('กำลังดำเนินการ');
            $table->string('withdraw_code')->nullable()->default('000000');
            $table->date('deposit_date')->default(DB::raw('CURRENT_TIMESTAMP'));
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
        Schema::dropIfExists('deposits');
    }
};
