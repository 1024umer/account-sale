<?php

namespace App\Models;

use App\Helpers\ImageUploadHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    use HasFactory;
    public const IMAGE_PATH = 'sub_category/';
    public const DEFAULT_IMAGE_PATH = null;

    protected $fillable = [
        'category_id',
        'name',
        'image',
    ];

    public function setImageAttribute($value)
    {
        $this->attributes['image'] = ImageUploadHelper::uploadImage(self::IMAGE_PATH, $value, null);
    }

    public function getImageAttribute($value)
    {
        return ImageUploadHelper::getImage($value, [600, 600], self::DEFAULT_IMAGE_PATH);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    
    public function gamingAccounts()
    {
        return $this->hasMany(GamingAccount::class);
    }

    public function subSubCategory()
    {
        return $this->hasMany(SubSubcategory::class);
    }
}
