<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   
    public function up(): void
{
    Schema::create('audit_logs', function (Blueprint $table) {
        $table->id();
        $table->foreignId('company_id')->constrained()->onDelete('cascade'); // The Company
        $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null'); // The User (nullable in case user is deleted later)
        $table->string('event');        // Short name: "file_uploaded", "user_invited"
        $table->text('description');    // Details: "Uploaded tank2.png"
        $table->string('ip_address')->nullable(); // Good for security
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('audit_logs');
    }
};
