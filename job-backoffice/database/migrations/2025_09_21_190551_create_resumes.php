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
        Schema::create('resumes', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('filename');
            $table->string('fileUri');
            $table->longText('contactDetails');
            $table->longText('education');
            $table->longText('summary');
            $table->longText('skills');
            $table->longText('experience');
            $table->timestamps();
            $table->softDeletes();

            // Foreign key to users table
            $table->uuid('userId');
            $table->foreign('userId')->references('id')->on('users')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resumes');
    }
};
