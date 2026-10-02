<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('incidents', function (Blueprint $table) {
            $table->id();
            $table->string('incident_number', 50)->unique();
            $table->string('title', 255);
            $table->text('description')->nullable();

            $table->string('severity', 20)->default('medium');
            $table->string('status', 30)->default('open');

            $table->foreignId('security_event_id')->nullable()->constrained('security_events')->nullOnDelete();

            $table->foreignId('reported_by')->nullable()->constrained('users')->nullOnDelete();

            $table->foreignId('assigned_to')->nullable()->constrained('users')->nullOnDelete();

            $table->timestamp('detected_at');
            $table->timestamp('resolved_at')->nullable();


            $table->timestamps();

            $table->index(['status', 'severity']);
            $table->index('detected_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('incidents');
    }
};
