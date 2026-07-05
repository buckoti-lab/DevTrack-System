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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('first_name', 100);
            $table->string('second_name', 100);
            $table->string('last_name', 100);
            $table->string('phone', 15)->nullable();
            $table->enum('sex', ['Male', 'Female']);
            $table->enum('role', ['Admin', 'Developer','Client']);
            $table->string('profile_picture')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users');
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
