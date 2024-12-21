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
        Schema::table('requirement_users', function (Blueprint $table) {
            $table->dropForeign(['requirement_id']);  // Drop the old foreign key
            $table->foreign('requirement_id')->references('id')->on('requirements')->onDelete('cascade');  // Add the new foreign key with cascade
        });
    }

    public function down(): void
    {
        Schema::table('requirement_users', function (Blueprint $table) {
            $table->dropForeign(['requirement_id']);  // Drop the foreign key in down method
        });
    }

};
