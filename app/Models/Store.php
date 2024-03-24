<?php

namespace App\Models;

use App\Helpers\ImageUploadHelper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Store extends Model
{
    use HasFactory;

    public const IMAGE_PATH = "store_data/";

    protected $fillable = [
        'meta_title',
        'meta_description',
        'meta_keywords',
        'stripe_key',
        'stripe_secret',
        'main_logo',
        'favicon',
        'facebook_link',
        'instagram_link',
        'discord_link',
        'telegram_link',
        'youtube_link',
        'privacy_policy',
        'terms_of_use',
        'payment_and_delivery',
        'company_email',
        'paypal_client_id',
        'paypal_secret',
        'paypal_mode',
        'coinbase_api_version',
        'coinbase_api_key',
        'user_id',
        'adminProfit',
    ];

    public function setFaviconAttribute($value)
    {
        $this->attributes['favicon'] = ImageUploadHelper::uploadImage(self::IMAGE_PATH, $value, null);
    }

    public function getFaviconAttribute($value)
    {
        return ImageUploadHelper::getImage($value, [24, 24], null);
    }

    public function setMainLogoAttribute($value)
    {
        $this->attributes['main_logo'] = ImageUploadHelper::uploadImage(self::IMAGE_PATH, $value, null);
    }

    public function getMainLogoAttribute($value)
    {
        return ImageUploadHelper::getImage($value, [180, 180], null);
    }
}
