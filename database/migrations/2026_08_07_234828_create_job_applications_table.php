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
    Schema::create('job_applications', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->cascadeOnDelete();
        $table->foreignId('job_post_id')->constrained()->cascadeOnDelete();
        $table->enum('status', ['pending', 'cancelled', 'accepted', 'rejected'])->default('pending');
        $table->timestamps();

        $table->unique(['user_id', 'job_post_id']);
    });
}

public function down(): void
{
    Schema::dropIfExists('job_applications');
}
};
