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
        Schema::create('knowledge_documents', function (Blueprint $table) {
            $table->id();
            $table->string('title', 255);
            $table->string('file_name', 255);
            $table->text('file_path');
            $table->string('file_type', 20);
            $table->integer('total_pages')->unsigned()->nullable();
            $table->integer('uploaded_by')->unsigned()->nullable();
            $table->enum('status', ['processed', 'pending', 'failed'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('knowledge_documents');
    }
};
