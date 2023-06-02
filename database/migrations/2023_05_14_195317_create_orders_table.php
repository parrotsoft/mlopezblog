<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('post_id');
            $table->string('order_id')->nullable();
            $table->string('provider');
            $table->string('url')->nullable();
            $table->double('amount', 16, 2);
            $table->enum('currency', ['COP'])->default('COP');
            $table->enum('status', ['PENDING', 'COMPLETED', 'CANCELED'])->default('PENDING');
            $table->timestamps();

            $table->foreign('user_id')->on('users')->references('id');
            $table->foreign('post_id')->on('posts')->references('id');
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
