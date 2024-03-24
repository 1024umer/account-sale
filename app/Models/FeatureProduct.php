<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeatureProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'product_type',
    ];

    public function product()
    {
        return $this->morphTo();
    }

    public function scopeSearch($query, $search)
    {
        return $query->whereHasMorph('product', ['App\Models\GamingAccount', 'App\Models\LicenceKey'], function ($relatedQuery) use ($search) {
            $relatedQuery->where('title', 'like', '%' . $search . '%');
        });
    }
}
