<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KeyChannel extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'status',
        'days',
        'price',
        'licence_key_id',
    ];

    public function licenceKey()
    {
        return $this->belongsTo(LicenceKey::class);
    }
}
