<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   public function up(): void
{
    Schema::create('plans', function (Blueprint $table) {
        $table->id();
        $table->string('name');          // e.g., "Pro Plan"
        $table->string('slug')->unique(); // e.g., "pro-monthly"
        $table->string('stripe_price_id')->unique(); // 👈 Bohat zaroori hai (e.g., price_1Soj...)
        $table->decimal('price', 8, 2);  
        $table->string('duration');      // "monthly" or "yearly"
        $table->integer('file_limit')->default(100); // Har plan ki apni limit set karein
        $table->timestamps();
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plans');
    }
};
