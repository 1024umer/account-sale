<?php

namespace App\Models;

use App\Helpers\ImageUploadHelper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GamingAccount extends Model
{
    use HasFactory;

    public const IMAGE_PATH = 'gaming_accounts/';
    public const DEFAULT_IMAGE_PATH = null;

    protected $fillable = [
        'title',
        'description',
        'price',
        'discount',
        'options',
        'status',
        'product_status',
        'sku',
        'stock',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'main_image',
        'long_image',
    ];

    public function setMainImageAttribute($value)
    {
        $this->attributes['main_image'] = ImageUploadHelper::uploadImage(self::IMAGE_PATH, $value, null);
    }

    public function setLongImageAttribute($value)
    {
        $this->attributes['long_image'] = ImageUploadHelper::uploadImage(self::IMAGE_PATH, $value, null);
    }

    public function getMainImageAttribute($value)
    {
        return ImageUploadHelper::getImage($value, [600, 600], self::DEFAULT_IMAGE_PATH);
    }

    public function getLongImageAttribute($value)
    {
        return ImageUploadHelper::getImage($value, [580, 760], self::DEFAULT_IMAGE_PATH);
    }

    public function scopeSearch($query, $search)
    {
        return $query->where('title', 'like', '%' . $search . '%');
    }

    public function emailChannels()
    {
        return $this->hasMany(EmailChannel::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function sub_category()
    {
        return $this->belongsTo(SubCategory::class);
    }

    public function sub_subcategory()
    {
        return $this->belongsTo(SubSubcategory::class);
    }

    public function medias()
    {
        return $this->morphMany(Media::class, 'mediable');
    }

    public function orders()
    {
        return $this->morphMany(Order::class, 'orderable');
    }

    public function featured()
    {
        return $this->morphMany(FeatureProduct::class, 'product');
    }

    public function outOfStocks()
    {
        return $this->hasMany(OutOfStock::class, 'product_id');
    }
}
