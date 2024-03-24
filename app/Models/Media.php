<?php

namespace App\Models;

use App\Helpers\ImageUploadHelper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Media extends Model
{
    use HasFactory;

    public const IMAGE_PATH = 'gaming_accounts/';
    public const DEFAULT_IMAGE_PATH = null;

    protected $fillable = [
        'mediable_id',
        'mediable_type',
        'image',
    ];

    public function mediable()
    {
        return $this->morphTo();
    }

    public function getImageAttribute($value)
    {
        return ImageUploadHelper::getImage($value, [780, 500], self::DEFAULT_IMAGE_PATH);
    }

    public function setImageAttribute($value)
    {
        $this->attributes['image'] = ImageUploadHelper::uploadImage(self::IMAGE_PATH, $value, null);
    }
}
