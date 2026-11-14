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
        Schema::table('participants', function (Blueprint $table) {
            $table->string('student_whatsapp', 30)->nullable()->after('school_name');
            $table->string('nickname', 60)->nullable()->change();
            $table->string('parent_name', 120)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('participants', function (Blueprint $table) {
            $table->dropColumn('student_whatsapp');
            $table->string('nickname', 60)->nullable(false)->change();
            $table->string('parent_name', 120)->nullable(false)->change();
        });
    }
};
