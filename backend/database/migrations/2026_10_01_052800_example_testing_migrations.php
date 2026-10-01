<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('exampleTest', function (Blueprint $table) {});
    }

    /**
     * Reverse or Rollback the migrations.
     */
    public function down(): void
    {
        //
    }
};
