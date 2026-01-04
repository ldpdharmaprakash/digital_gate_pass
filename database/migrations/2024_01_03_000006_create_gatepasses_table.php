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
        Schema::create('gatepasses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained()->onDelete('cascade');
            $table->date('gatepass_date');
            $table->time('out_time');
            $table->time('in_time');
            $table->text('reason');
            $table->enum('status', ['pending', 'staff_approved', 'staff_rejected', 'hod_approved', 'hod_rejected', 'warden_approved', 'warden_rejected', 'final_approved', 'final_rejected'])->default('pending');
            $table->text('staff_remarks')->nullable();
            $table->text('hod_remarks')->nullable();
            $table->text('warden_remarks')->nullable();
            $table->timestamp('staff_approved_at')->nullable();
            $table->timestamp('hod_approved_at')->nullable();
            $table->timestamp('warden_approved_at')->nullable();
            $table->timestamp('final_approved_at')->nullable();
            $table->foreignId('staff_approved_by')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('hod_approved_by')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('warden_approved_by')->nullable()->constrained('users')->onDelete('set null');
            $table->string('qr_code')->unique()->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gatepasses');
    }
};
