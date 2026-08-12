<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
public function up(): void
{
    Schema::create('candidate_profiles', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->unique()->constrained()->cascadeOnDelete();
        $table->string('full_name');
        $table->unsignedTinyInteger('age')->nullable();
        $table->string('job_title')->nullable();
        $table->text('description')->nullable();
        $table->string('phone_number')->nullable();
        $table->json('skills')->nullable();
        $table->string('profile_image')->nullable();
        $table->string('resume')->nullable();
        $table->timestamps();
    });
}

public function down(): void
{
    Schema::dropIfExists('candidate_profiles');
}
};
