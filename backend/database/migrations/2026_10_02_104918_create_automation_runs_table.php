<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('automation_runs', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->foreignId('lab_id')
                ->nullable()
                ->constrained('labs')
                ->nullOnDelete();

            $table->string('operation', 100);
            $table->string('status', 30)->default('pending');

            $table->json('input')->nullable();
            $table->json('result')->nullable();

            $table->text('error_message')->nullable();

            $table->timestamp('started_at')->nullable();
            $table->timestamp('completed_at')->nullable();

            $table->timestamps();

            $table->index(['status', 'created_at']);
            $table->index(['user_id', 'created_at']);
            $table->index('lab_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('automation_runs');
    }
};