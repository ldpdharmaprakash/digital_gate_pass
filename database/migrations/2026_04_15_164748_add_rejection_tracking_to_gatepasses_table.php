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
        Schema::table('gatepasses', function (Blueprint $table) {
            $table->unsignedBigInteger('staff_rejected_by')->nullable()->after('warden_approved_by');
            $table->unsignedBigInteger('hod_rejected_by')->nullable()->after('staff_rejected_by');
            $table->unsignedBigInteger('warden_rejected_by')->nullable()->after('hod_rejected_by');
            $table->timestamp('staff_rejected_at')->nullable()->after('warden_approved_at');
            $table->timestamp('hod_rejected_at')->nullable()->after('staff_rejected_at');
            $table->timestamp('warden_rejected_at')->nullable()->after('hod_rejected_at');
            
            // Add foreign key constraints
            $table->foreign('staff_rejected_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('hod_rejected_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('warden_rejected_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('gatepasses', function (Blueprint $table) {
            $table->dropForeign(['staff_rejected_by']);
            $table->dropForeign(['hod_rejected_by']);
            $table->dropForeign(['warden_rejected_by']);
            $table->dropColumn([
                'staff_rejected_by',
                'hod_rejected_by',
                'warden_rejected_by',
                'staff_rejected_at',
                'hod_rejected_at',
                'warden_rejected_at'
            ]);
        });
    }
};
