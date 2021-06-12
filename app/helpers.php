<?php
use Intervention\Image\Facades\Image;
use App\Models\Category;

    // function to resize image based on width and height 
    if(!function_exists('image_crop')){
        function image_crop($image_name,$width=550,$height=750){
            // here I am creating a new image name based on their size and generating their thumbnail for different sizes
            $new_image_name = $width."x".$height."_".$image_name;
            // dd($image_name);
            //! instead of creating the new image in images I later directly created it in thumbnail
            // if(!file_exists(storage_path('app/public/images/'.$new_image_name))){
            //     // dd($image_name);
            //     $resized_image = Image::make(storage_path('app/public/images/'.$image_name));
            //     $new_image_name = $width."x".$height."_".$image_name;
            //     // dd($new_image_name);
            //     $resized_image->save(storage_path('app/public/images/'.$new_image_name));
            // }

            if(
                file_exists(storage_path('app/public/images/'.$image_name)) && 
                !file_exists(storage_path('app/public/images/thumbnail/'.$new_image_name))
            ){
                $image_resize = Image::make(storage_path('app/public/images/'.$image_name));
                $image_resize->resize($width, $height);
                $image_resize->save(storage_path('app/public/images/thumbnail/'.$new_image_name));
            }

            
            return asset('storage/images/thumbnail/'.$new_image_name);
        }
    }

    // helper function for generating categories list instead of generating it in controllers
    if(!function_exists('categories_list')){
        function categories_list(){
            // return Category::where('parent_id', 0)->get();
            return Category::whereParentId(0)->get();
        }
    } 

    // helper function to generate code 
    if(!function_exists('getSecurityCode')){
        function getSecurityCode($length=8){
            $code = '';
            for($i=0;$i<$length;$i++){
                $code .= mt_rand(0,9);
            }
            return $code;
        }
    }

?>