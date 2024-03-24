<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'status',
        'amount',
        'orderable_id',
        'orderable_type',
        'easy_mode',
    ];

    public function scopeSearch($query, $search)
    {
        return $query->whereHasMorph('orderable', ['App\Models\GamingAccount', 'App\Models\LicenceKey'], function ($relatedQuery) use ($search) {
            $relatedQuery->where('title', 'like', '%' . $search . '%');
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function orderable()
    {
        return $this->morphTo();
    }

    public function transaction()
    {
        return $this->hasOne(Transaction::class);
    }
     public function emailChannels()
    {
        return $this->hasMany(EmailChannel::class);
    }
}
