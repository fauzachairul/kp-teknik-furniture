<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StockIn extends Model
{
    protected $fillable = [
        'bahan_baku_id',
        'kode_transaksi',
        'jumlah',
        'keterangan',
    ];


    public function rawMaterial(): BelongsTo
    {
        return $this->belongsTo(BahanBaku::class, 'bahan_baku_id');
    }
}
