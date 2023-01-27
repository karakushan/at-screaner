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
        Schema::create('currencies', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('name');
            $table->foreignId('exchange_id')->constrained()->onDelete('cascade');
            $table->string('chain')->nullable();
            $table->boolean('delisted')->nullable();
            $table->boolean('withdraw_disabled')->nullable();
            $table->boolean('deposit_disabled')->nullable();
            $table->boolean('trade_disabled')->nullable();
            $table->text('description')->nullable();
            $table->string('logo')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('currencies');
    }
};
