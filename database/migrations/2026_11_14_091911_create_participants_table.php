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
        Schema::create('participants', function (Blueprint $table) {
            $table->id();
            $table->string('reg_code', 20)->unique();
            $table->string('student_name', 120);
            $table->string('nickname', 60);
            $table->string('school_name', 150);
            $table->enum('gender', ['L', 'P'])->default('L');
            $table->string('experience_level', 60)->default('Belum Pernah');
            $table->string('parent_name', 120);
            $table->string('whatsapp', 30)->index();
            $table->string('email', 150)->nullable();
            $table->enum('status', ['UTAMA', 'CADANGAN', 'DIBATALKAN'])->default('UTAMA')->index();
            $table->unsignedInteger('waitlist_order')->nullable()->index();
            $table->boolean('is_attended')->default(false)->index();
            $table->timestamp('attended_at')->nullable();
            $table->text('cancellation_reason')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('participants');
    }
};
