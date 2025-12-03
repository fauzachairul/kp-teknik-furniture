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
        Schema::create('stock_outs', function (Blueprint $table) {
            $table->id();
            $table->string('stock_out_kode')->unique();
            $table->unsignedBigInteger('project_id')->nullable();
            $table->enum('jenis_pengeluaran', ['produksi', 'rusak', 'hilang', 'lainnya']);
            $table->text('keterangan');
            $table->dateTime('tanggal_keluar');
            $table->timestamps();

            $table->foreign('project_id')->references('id')->on('projects')->onDelete('set null');

            $table->foreignId('user_id')->constrained()->after('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_outs');
    }
};
