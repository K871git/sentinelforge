<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ai_analyses', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->foreignId('security_event_id')
                ->nullable()
                ->constrained('security_events')
                ->nullOnDelete();

            $table->foreignId('incident_id')
                ->nullable()
                ->constrained('incidents')
                ->nullOnDelete();

            $table->string('analysis_type', 100);
            $table->string('model_name', 150)->nullable();
            $table->string('status', 30)->default('pending');

            $table->json('input')->nullable();
            $table->json('result')->nullable();

            $table->text('error_message')->nullable();

            $table->timestamp('started_at')->nullable();
            $table->timestamp('completed_at')->nullable();

            $table->timestamps();

            $table->index(['status', 'created_at']);
            $table->index(['analysis_type', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ai_analyses');
    }
};