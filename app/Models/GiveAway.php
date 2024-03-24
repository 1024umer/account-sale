<?php

namespace App\Models;

use App\Helpers\ImageUploadHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GiveAway extends Model
{
    use HasFactory;
    protected $table = 'give_aways';
    protected $primaryKey = 'id';
    public const IMAGE_PATH = 'giveaway/';
    public const DEFAULT_IMAGE_PATH = null;
    protected $fillable = [
        'title',
        'description',
        'status',
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
}
