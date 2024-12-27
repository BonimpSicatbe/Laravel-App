<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequirementUserSubmissionsTable extends Migration
{
    public function up()
    {
        Schema::create('requirement_user_submissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('requirement_id')->constrained()->onDelete('cascade');  // Foreign key to the requirements table
            $table->foreignId('user_id')->constrained()->onDelete('cascade');  // Foreign key to the users table
            $table->timestamp('submitted_at')->nullable();  // Track submission time (if applicable)
            $table->timestamps();  // Default timestamps (created_at, updated_at)
        });
    }

    public function down()
    {
        Schema::dropIfExists('requirement_user_submissions');
    }
}

