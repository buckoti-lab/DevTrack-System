<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('quotes', function (Blueprint $table) {
            // Add client_id column (unsigned big integer)
            $table->unsignedBigInteger('client_id')->nullable()->after('id');

            // If you want foreign key relation to users/clients table:
             $table->foreign('client_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('quotes', function (Blueprint $table) {
            // Rollback: drop the foreign key first (if added)
             $table->dropForeign(['client_id']);

            $table->dropColumn('client_id');
        });
    }
};
