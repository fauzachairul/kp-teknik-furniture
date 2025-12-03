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
        Schema::create('detail_outs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('stock_out_id');
            $table->unsignedBigInteger('bahan_baku_id');
            $table->integer('jumlah');
            $table->text('keterangan')->nullable();
            $table->timestamps();

            $table->foreign('stock_out_id')->references('id')->on('stock_outs')->onDelete('cascade');
            $table->foreign('bahan_baku_id')->references('id')->on('bahan_bakus')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_outs');
    }
};
