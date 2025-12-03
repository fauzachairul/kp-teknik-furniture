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
        Schema::create('bahan_bakus', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('bahan_baku_kd')->unique();
            $table->foreignId('category_id')->constrained(
                table: 'categories',
                indexName: 'bahan_bakus_category_id',
            );
            $table->foreignId('unit_id')->constrained(
                table: 'units',
                indexName: 'bahan_bakus_unit_id',
            );
            $table->integer('stock');
            $table->integer('min_stock');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bahan_bakus');
    }
};
