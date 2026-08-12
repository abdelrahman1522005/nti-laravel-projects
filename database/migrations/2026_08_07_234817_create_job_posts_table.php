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
    Schema::create('job_posts', function (Blueprint $table) {
        $table->id();
        $table->foreignId('admin_id')->constrained('users')->cascadeOnDelete();
        $table->foreignId('category_id')->nullable()->constrained()->nullOnDelete();
        $table->string('title');
        $table->text('description');
        $table->json('required_skills')->nullable();
        $table->string('location')->nullable();
        $table->enum('work_type', ['remote', 'on-site', 'hybrid'])->default('on-site');
        $table->decimal('salary', 10, 2)->nullable();
        $table->date('application_deadline')->nullable();
        $table->timestamps();
    });
}

public function down(): void
{
    Schema::dropIfExists('job_posts');
}
};
