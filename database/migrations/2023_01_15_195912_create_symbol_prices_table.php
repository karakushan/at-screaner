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
        Schema::create('symbol_prices', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('symbol_id')->constrained();
            $table->foreignId('exchange_id')->constrained();
            $table->float('price', 10, 10);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('symbol_prices');
    }
};
