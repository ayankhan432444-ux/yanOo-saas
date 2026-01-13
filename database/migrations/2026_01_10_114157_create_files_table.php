<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('files', function (Blueprint $table) {
            $table->id();
            
            // 1. Company ID (Nullable for Super Admin bypass)
            $table->foreignId('company_id')->nullable()->constrained()->onDelete('cascade');
            
            // 2. User ID (Required for Audit Logs & File Ownership)
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            // 3. File Metadata (Matching Controller Logic)
            $table->string('filename'); // Original name e.g., "tank.png"
            $table->string('path');     // Storage path e.g., "uploads/123_tank.png"
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('files');
    }
};