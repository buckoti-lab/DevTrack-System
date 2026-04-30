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
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('uploaded_by')->constrained('users');
            $table->foreignId('updated_by')->constrained('users')->nullable();
            $table->string('name',250);
            $table->enum('type',['functional_requirements','project_proposal',"srs"]);
            $table->text('description',500)->nullable();
            $table->string('filename');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
