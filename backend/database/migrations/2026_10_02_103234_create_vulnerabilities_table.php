<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vulnerabilities', function (Blueprint $table) {
            $table->id();

            $table->string('cve_id', 30)->nullable()->unique();
            $table->string('title', 255);
            $table->text('description')->nullable();

            $table->string('severity', 20)->default('medium');
            $table->decimal('cvss_score', 3, 1)->nullable();

            $table->string('affected_product', 255)->nullable();
            $table->string('affected_version', 255)->nullable();

            $table->text('remediation')->nullable();
            $table->json('references')->nullable();

            $table->timestamp('published_at')->nullable();

            $table->timestamps();

            $table->index('severity');
            $table->index('published_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vulnerabilities');
    }
};
