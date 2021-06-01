<?php
use Intervention\Image\Facades\Image;
    // function to resize image based on width and height 
    if(!function_exists('image_crop')){
        function image_crop($image_name,$width=550,$height=750){
            if(
                file_exists(storage_path('app/public/images'.$image_name))
                && 
                !file_exists(storage_path('app/public/images/thumbnail/'.$image_name))
            ){
                $image_resize = Image::make(storage_path('app/public/images/'.$image_name));
                $image_resize->resize($width,$height);
                $image_resize->save(storage_path('app/public/images/thumbnail/'.$image_name));
            }
            return asset('storage/images/thumbnail/'.$image_name);
        }
    }


?>