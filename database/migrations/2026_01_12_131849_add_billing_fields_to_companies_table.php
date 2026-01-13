<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB; 

return new class extends Migration
{
    public function up(): void
    {
        // 1. Columns add karein
        Schema::table('companies', function (Blueprint $table) {
            // Check karein agar columns pehle se nahi hain
            if (!Schema::hasColumn('companies', 'file_limit')) {
                $table->integer('file_limit')->default(2)->after('status');
            }
            if (!Schema::hasColumn('companies', 'plan_name')) {
                $table->string('plan_name')->default('Trial')->after('file_limit');
            }
        });

        // 2. ENUM ko update karein taake 'active' allow ho sake
        DB::statement("ALTER TABLE companies MODIFY COLUMN status ENUM('pending', 'approved', 'rejected', 'active') DEFAULT 'pending'");
    }

    public function down(): void
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->dropColumn(['file_limit', 'plan_name']);
            // Status ko wapis puranay halat mein lane ke liye
            DB::statement("ALTER TABLE companies MODIFY COLUMN status ENUM('pending', 'approved', 'rejected') DEFAULT 'pending'");
        });
    }
};