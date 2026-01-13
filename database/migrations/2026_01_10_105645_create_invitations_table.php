<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\AuditLog;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::create('invitations', function (Blueprint $table) {
        $table->id();
        $table->foreignId('company_id')->constrained()->onDelete('cascade');
        $table->string('email');
        $table->string('token')->unique();
        $table->string('role_name')->default('normal_user'); 
        $table->enum('status', ['pending', 'accepted'])->default('pending');
        
        // 👇 THIS IS THE MISSING LINE 👇
        $table->timestamp('expires_at')->nullable(); // <--- ADD THIS LINE
        
        $table->timestamps();
        
        // Prevent inviting the same email twice to the same company
    });
}

};
