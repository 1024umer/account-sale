<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;
    public $with = ['user','gamingAccount'];
    protected $fillable = ['user_id','gaming_account_id','star','comment','image'];
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function gamingAccount(){
        return $this->belongsTo(GamingAccount::class);
    }
}
