<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('incident_investigations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('incident_id')
                ->constrained('incidents')
                ->cascadeOnDelete();

            $table->foreignId('investigator_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->string('activity_type', 50);
            $table->text('notes')->nullable();
            $table->text('findings')->nullable();
            $table->string('status', 30)->default('in_progress');

            $table->timestamps();

            $table->index(['incident_id', 'created_at']);
            $table->index('investigator_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('incident_investigations');
    }
};
