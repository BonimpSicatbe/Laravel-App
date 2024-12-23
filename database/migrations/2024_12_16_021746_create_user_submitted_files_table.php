<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('user_submitted_files', function (Blueprint $table) {
            $table->id();
            $table->string('file_name');
            $table->string('size');
            $table->string('type');
            $table->string('file_path');
            $table->foreignId('user_id')->constrained();
            $table->foreignId('requirement_id')->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('submitted_files');
    }
};
