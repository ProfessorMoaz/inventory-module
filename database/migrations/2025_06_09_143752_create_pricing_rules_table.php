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
        Schema::create('pricing_rules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->enum('type', ['time', 'quantity']);
            $table->json('condition'); // JSON: { "days": [...], "start": "08:00", "end": "18:00" }
            $table->decimal('discount', 5, 2);
            $table->integer('precedence')->default(1);
            $table->timestamp('valid_from');
            $table->timestamp('valid_to');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pricing_rules');
    }
};
