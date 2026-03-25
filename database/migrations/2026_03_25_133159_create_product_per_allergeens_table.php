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
        Schema::create('product_per_allergeens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ProductId')->constrained('products')->cascadeOnDelete();
            $table->foreignId('AllergeenId')->constrained('allergeens')->cascadeOnDelete();
            $table->boolean('IsActief')->default(true);
            $table->string('Opmerking', 250)->nullable();
            $table->dateTime('DatumAangemaakt');
            $table->dateTime('DatumGewijzigd');
            $table->unique(['ProductId', 'AllergeenId']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_per_allergeens');
    }
};
