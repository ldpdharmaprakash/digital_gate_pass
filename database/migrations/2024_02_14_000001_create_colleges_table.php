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
        Schema::create('colleges', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code')->unique();
            $table->string('primary_color')->default('#3B82F6'); // Blue
            $table->string('secondary_color')->default('#8B5CF6'); // Violet
            $table->text('address')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Insert default colleges
        DB::table('colleges')->insert([
            [
                'name' => 'Engineering College',
                'code' => 'ENG',
                'primary_color' => '#3B82F6', // Blue
                'secondary_color' => '#8B5CF6', // Violet
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Women\'s Arts & Science College',
                'code' => 'WOM',
                'primary_color' => '#800020', // Maroon
                'secondary_color' => '#FFC0CB', // Pink
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Polytechnic College',
                'code' => 'POLY',
                'primary_color' => '#FFA500', // Orange
                'secondary_color' => '#696969', // Dark Gray
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('colleges');
    }
};
