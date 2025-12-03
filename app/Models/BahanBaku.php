<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BahanBaku extends Model
{
    protected $fillable = [
        'name',
        'bahan_baku_kd',
        'category_id',
        'unit_id',
        'stock',
        'min_stock',
    ];


    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function unit(): BelongsTo
    {
        return $this->belongsTo(Unit::class);
    }

    public function stockIn(): HasMany
    {
        return $this->hasMany(StockIn::class);
    }


    public function detailOut(): HasMany
    {
        return $this->hasMany(DetailOut::class);
    }
}
