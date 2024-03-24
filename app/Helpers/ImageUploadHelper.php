<?php // Code within app\Helpers\Helper.php

namespace App\Helpers;

use Config;
use Intervention\Image\Response;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class ImageUploadHelper
{
    public static function uploadImage($directory, $image, $oldImage = null, $extension = null)
    {
        if ($oldImage != null) {
            self::removeImage($oldImage);
        }
        if ($extension) {
            $imageName = Str::random(8) . time() . Str::random(8) . '.' . $extension;
        } else {
            $imageName = Str::random(8) . time() . Str::random(8) . '.' . $image->getClientOriginalExtension();
        }
        return Storage::putFileAs($directory, $image, $imageName);
    }

    public static function getImage($image, $size = [], $default = null)
    {
        if ($image != null && Storage::exists($image)) {
            if (count($size) > 0) {
                return Image::make(Storage::path($image))->resize($size[0], $size[1])->encode('data-url');
            } else {
                return Image::make(Storage::path($image))->encode('data-url');
            }
        } else {
            return asset($default);
        }
    }

    public static function removeImage($image)
    {
        if (Storage::exists($image)) {
            Storage::delete($image);
        }
    }
}
