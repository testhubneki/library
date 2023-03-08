<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ImageController extends Controller
{
    
   private $picture = 'default_picture.png';

   /**
    * @paramIN(request) 
    * check size and type extensio
    * check if has file image,
    * get extension of picture rename to timestamp and add extension
    * move picture to foldername
    * return name of picture, name is default name if doesn't have picture or name posted picture
    */
   
   public function imageSave($request)
   {
         if($request->hasfile('image'))  
        {  
             
            $file = $request->file('image');  
            $extension = $file->getClientOriginalExtension();  
            $filename = time().'.'.$extension;  
            $file->move('images/',$filename);  
            $name_image = $filename;  
            
        }  
        $image = ($request->hasfile('image')) ? $name_image :$this->picture ; 
        return $image;
   }
    
}
