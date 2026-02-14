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
        // Add college_id to users table if not exists
        if (!Schema::hasColumn('users', 'college_id')) {
            Schema::table('users', function (Blueprint $table) {
                $table->foreignId('college_id')->default(1)->after('id')->constrained('colleges')->onDelete('cascade');
            });
        }

        // Add gender to users table if not exists
        if (!Schema::hasColumn('users', 'gender')) {
            Schema::table('users', function (Blueprint $table) {
                $table->enum('gender', ['male', 'female', 'other'])->default('other')->after('phone');
            });
        }

        // Add college_id to departments table if not exists
        if (!Schema::hasColumn('departments', 'college_id')) {
            Schema::table('departments', function (Blueprint $table) {
                $table->foreignId('college_id')->default(1)->after('id')->constrained('colleges')->onDelete('cascade');
            });
        }

        // Add college_id to gatepasses table if not exists
        if (!Schema::hasColumn('gatepasses', 'college_id')) {
            Schema::table('gatepasses', function (Blueprint $table) {
                $table->foreignId('college_id')->default(1)->after('id')->constrained('colleges')->onDelete('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['college_id']);
            $table->dropColumn(['college_id', 'gender']);
        });

        Schema::table('departments', function (Blueprint $table) {
            $table->dropForeign(['college_id']);
            $table->dropColumn('college_id');
        });

        Schema::table('gatepasses', function (Blueprint $table) {
            $table->dropForeign(['college_id']);
            $table->dropColumn('college_id');
        });
    }
};
