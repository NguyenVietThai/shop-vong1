<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Intervention\Image\ImageManagerStatic as Image;

class Product extends Model
{
    protected $table = 'products';

    protected $fillable = ['name', 'description', 'price', 'quantity'];

    public static function createImage($image, $old_image = "default.png")
    {
        if(!empty($image) && substr($image->getMimeType(), 0, 5) == 'image'){
            $img = $image->getClientOriginalName();
            $thumbnail = Image::make($image->getRealPath())->resize(500, 500);
            $thumbnail->save('images/products/' . strtotime("now") . $img);
            $avatar = strtotime("now") . $img;
            return $avatar;
        }
        return $old_image;
    }
}

