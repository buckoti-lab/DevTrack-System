<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('quotes', function (Blueprint $table) {
            $table->id();

            $table->string("project_title",200);
            $table->enum("status",["pending","rejected","accepted"])->dafault("pending");

            // Company Details
            $table->string('company_name');
            $table->text('company_address')->nullable();
            $table->string('company_email')->nullable();
            $table->string('company_contact')->nullable();
            $table->date('company_date')->nullable();
            $table->string('company_website')->nullable();

            // Client Details
            $table->string('client_name');
            $table->text('client_address')->nullable();
            $table->string('client_email')->nullable();
            $table->string('client_contact')->nullable();
            $table->string('quote_number')->nullable();
            $table->date('quote_valid_date')->nullable();

            // Items stored as JSON
            $table->json('items')->nullable();

            $table->decimal('sub_total', 12, 2)->default(0);
            $table->decimal('tax', 12, 2)->default(0);
            $table->decimal('discount', 12, 2)->default(0);
            $table->decimal('grand_total', 12, 2)->default(0);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('quotes');
    }
};
