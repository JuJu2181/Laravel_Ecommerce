<?php
use Intervention\Image\Facades\Image;
use App\Models\Category;

    // function to resize image based on width and height 
    if(!function_exists('image_crop')){
        function image_crop($image_name,$width=550,$height=750){
            if(
                file_exists(storage_path('app/public/images/'.$image_name)) && 
                !file_exists(storage_path('app/public/images/thumbnail/'.$image_name))
            ){
                $image_resize = Image::make(storage_path('app/public/images/'.$image_name));
                $image_resize->resize($width, $height);
                $image_resize->save(storage_path('app/public/images/thumbnail/'.$image_name));
            } 
            return asset('storage/images/thumbnail/'.$image_name);
        }
    }

    // helper function for generating categories list instead of generating it in controllers
    if(!function_exists('categories_list')){
        function categories_list(){
            // return Category::where('parent_id', 0)->get();
            return Category::whereParentId(0)->get();
        }
    } 


?>