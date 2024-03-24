<?php

namespace App\Models;

use App\Models\CouponAccount;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CouponType extends Model
{
    use HasFactory;

    public function emailChannels()
    {
        return $this->hasMany(CouponAccount::class);
    }

    public function couponAccounts()
    {
        return $this->hasMany(CouponAccount::class);
    }
}
