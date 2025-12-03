<?php

namespace App\Models;

use App\Models\StockOut;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Project extends Model
{
    protected $fillable = [
        'project_kode',
        'name',
        'customer_name',
        'tanggal_mulai',
        'tanggal_selesai',
        'status',
    ];
    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
    ];

    public function stockOut(): HasMany
    {
        return $this->hasMany(StockOut::class);
    }
}
