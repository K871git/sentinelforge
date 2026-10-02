<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('labs', function (Blueprint $table) {
            $table->id();

            $table->string('lab_key', 100)->unique();
            $table->string('title', 255);
            $table->text('description')->nullable();

            $table->string('category', 100);
            $table->string('difficulty', 30)->default('beginner');

            $table->text('instructions')->nullable();
            $table->json('configuration')->nullable();

            $table->boolean('is_active')->default(true);

            $table->foreignId('created_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamps();

            $table->index(['category', 'is_active']);
            $table->index('difficulty');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('labs');
    }
};