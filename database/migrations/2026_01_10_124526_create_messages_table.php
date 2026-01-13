<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   // database/migrations/xxxx_create_messages_table.php
public function up() {
    Schema::create('messages', function (Blueprint $table) {
        $table->id();
        $table->foreignId('company_id')->constrained()->onDelete('cascade'); // Tenant Isolation
        $table->foreignId('user_id')->constrained()->onDelete('cascade');    // Sender
        $table->text('message');
        $table->boolean('is_read')->default(false); // Unread status
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
