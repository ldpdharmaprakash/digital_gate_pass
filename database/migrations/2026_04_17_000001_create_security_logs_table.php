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
        Schema::create('security_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('gatepass_id');
            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('verified_by')->nullable();
            $table->enum('action', ['exit', 'entry'])->default('exit');
            $table->timestamp('exit_time')->nullable();
            $table->timestamp('entry_time')->nullable();
            $table->text('notes')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->string('location')->nullable();
            $table->timestamps();
            
            // Foreign keys
            $table->foreign('gatepass_id')->references('id')->on('gatepasses')->onDelete('cascade');
            $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
            $table->foreign('verified_by')->references('id')->on('users')->onDelete('set null');
            
            // Indexes
            $table->index(['gatepass_id', 'action']);
            $table->index(['student_id', 'created_at']);
            $table->index('verified_by');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('security_logs');
    }
};
