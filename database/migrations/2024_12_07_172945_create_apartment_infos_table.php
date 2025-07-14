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
        Schema::create('apartment_infos', function (Blueprint $table) { // Singular table name is clearer
            $table->id();
            $table->string('content'); // Content for the bullet points
            $table->string('locale', 5); // Locale column, e.g., 'en', 'hr'
            $table->foreignId('apartment_id') // Foreign key column
                ->constrained('apartments') // References the 'apartments' table
                ->cascadeOnDelete(); // Cascade delete for related rows
            $table->timestamps(); // Created_at and updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('apartment_infos');
    }
};
