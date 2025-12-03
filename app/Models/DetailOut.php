<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailOut extends Model
{
    protected $fillable = [
        'stock_out_id',
        'bahan_baku_id',
        'jumlah',
        'keterangan',
    ];

    public function stokKeluar()
    {
        return $this->belongsTo(StockOut::class, 'stock_out_id');
    }

    public function rawMaterial()
    {
        return $this->belongsTo(BahanBaku::class, 'bahan_baku_id');
    }
}
