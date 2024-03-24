<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CouponAccount extends Model
{
    use HasFactory;

    public function couponType()
    {
        return $this->belongsTo(CouponType::class);
    }
}
