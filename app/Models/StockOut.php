<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockOut extends Model
{
    protected $fillable = [
        'user_id',
        'stock_out_kode',
        'project_id',
        'jenis_pengeluaran',
        'keterangan',
        'tanggal_keluar',
    ];

    public function detailOuts()
    {
        return $this->hasMany(DetailOut::class);
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
