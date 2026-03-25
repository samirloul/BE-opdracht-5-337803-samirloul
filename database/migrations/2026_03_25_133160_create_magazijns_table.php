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
        Schema::create('magazijns', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ProductId')->constrained('products')->cascadeOnDelete();
            $table->decimal('VerpakkingsEenheid', 5, 2);
            $table->integer('AantalAanwezig')->nullable();
            $table->boolean('IsActief')->default(true);
            $table->string('Opmerking', 250)->nullable();
            $table->dateTime('DatumAangemaakt');
            $table->dateTime('DatumGewijzigd');
            $table->unique(['ProductId', 'VerpakkingsEenheid']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('magazijns');
    }
};
