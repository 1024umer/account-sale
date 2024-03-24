<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubSubcategory extends Model
{
    use HasFactory;
    protected $table = 'sub_subcategories';
    protected $primaryKey = 'id';

    public function subCategory()
    {
        return $this->belongsTo(SubCategory::class);
    }
    public function gamingAccounts()
    {
        return $this->hasMany(GamingAccount::class);
    }
}
