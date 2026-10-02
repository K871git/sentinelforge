<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->string('title', 255);
            $table->string('report_type', 100);
            $table->string('status', 30)->default('pending');

            $table->json('filters')->nullable();
            $table->json('data')->nullable();

            $table->string('file_path', 500)->nullable();
            $table->string('file_format', 20)->nullable();

            $table->text('error_message')->nullable();

            $table->timestamp('generated_at')->nullable();

            $table->timestamps();

            $table->index(['report_type', 'created_at']);
            $table->index(['status', 'created_at']);
            $table->index(['user_id', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};