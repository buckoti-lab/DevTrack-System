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
        Schema::create('demos', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('project_id')->constrained("projects")->onDelete("cascade");
            $table->string("description",500);
            $table->enum("type",["video","image"]);
            $table->string("filename");
            $table->foreignId('uploaded_by')->constrained("users")->onDelete("cascade");
            $table->foreignId("updated_by")->constrained("users")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('demo');
    }
};
