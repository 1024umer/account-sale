<?php

namespace App\Models;

use App\Helpers\ImageUploadHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    public const IMAGE_PATH = 'category/';
    public const DEFAULT_IMAGE_PATH = null;

    protected $fillable = [
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

    // search
    public function scopeSearch($query, $search)
    {
        return $query->where('name', 'like', '%' . $search . '%');
    }

    public function subCategories()
    {
        return $this->hasMany(SubCategory::class);
    }

    public function gamingAccounts()
    {
        return $this->hasMany(GamingAccount::class);
    }

    public function licenceKeys()
    {
        return $this->hasMany(LicenceKey::class);
    }
}
