<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('security_checklists', function (Blueprint $table) {
            $table->id();

            $table->string('checklist_key', 100)->unique();
            $table->string('category', 100);
            $table->string('title', 255);
            $table->text('description')->nullable();
            $table->text('guidance')->nullable();

            $table->string('severity', 20)->default('medium');
            $table->boolean('is_active')->default(true);
            $table->unsignedInteger('sort_order')->default(0);

            $table->timestamps();

            $table->index(['category', 'is_active']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('security_checklists');
    }
};