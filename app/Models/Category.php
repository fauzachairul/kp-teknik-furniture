<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    protected $fillable = [
        'name',
        'description',
    ];


    public function rawMaterials(): HasMany
    {
        return $this->hasMany(BahanBaku::class, 'bahan_baku_id');
    }
}
