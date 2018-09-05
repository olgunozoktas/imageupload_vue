<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ImageRequest;

class ImageController extends Controller
{
    //

    public function upload(ImageRequest $request){
        
        //image is the name of the field thas has been written in app.blade.php
        if($request->hasFile('image')){
            //$request->image->store('public');
            //it will store the image to the store/public folder with an something ver long encrypted name
            //But we need to save the file with an original name so we need to use following code
            $imagename = $request->image->getClientOriginalName(); //this is as built-in function in UploadedFile.php (check more), gets the original name of the file
            $request->image->storeAs('public', $imagename);
            //Basically it will store the file to the store/public folder with an original name

            /* To put the files automatically to the public folder of the app is very easy we have to use following command
                php artisan storage:link -> basically it links the storage folder to the public folder of the app 
                not the storage/public -> it will get the elements from the storage/public folder and it will put all those files
                into the public/storage (this is not in the storage careful) */
        }

        $request->user()->avatar = $imagename;
        $request->user()->save();
        return back();

        return 'done';
    }
}
