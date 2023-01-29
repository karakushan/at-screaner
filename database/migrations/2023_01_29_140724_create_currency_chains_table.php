<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('currency_chains', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('name');
            $table->string('type')->nullable();
            $table->boolean('can_deposit')->nullable();
            $table->boolean('can_withdraw')->nullable();
            $table->decimal('withdraw_fee', 16, 8)->nullable();
            $table->decimal('deposit_min', 16, 8)->nullable();
            $table->decimal('withdraw_min', 16, 8)->nullable();
            $table->unsignedBigInteger('exchange_id')->nullable();
            $table->foreign('exchange_id')->references('id')->on('exchanges');
            $table->unsignedBigInteger('currency_id')->nullable();
            $table->foreign('currency_id')->references('id')->on('currencies');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('currency_chains');
    }
};
