<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            // Order info
            $table->string('order_number')->unique();

            // Customer info (guest checkout)
            $table->string('name');
            $table->string('email');
            $table->string('phone');
            $table->text('address');

            // Money
            $table->decimal('total', 10, 2);

            // Status
            $table->string('status')->default('pending');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
