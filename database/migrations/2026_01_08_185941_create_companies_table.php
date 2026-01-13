<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   // database/migrations/xxxx_create_companies_table.php
public function up() {
    Schema::create('companies', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->string('business_type')->nullable(); // [cite: 29]
        // Status: Pending -> Approved/Rejected [cite: 30, 38]
        $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
        // Trial Logic [cite: 31]
        $table->timestamp('trial_ends_at')->nullable();
        $table->timestamps();
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
