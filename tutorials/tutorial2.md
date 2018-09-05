

Step 1: Add fields for image upload

Step 2: Create a ImageController

Lets create an Controller for Images to upload them

~~~~

php artisan make:controller ImageControlelr

~~~~

Step 3: Add a upload function to the ImageController

Lets add a function to the ImageController to upload the picture

~~~~

    public function upload(Request $request){
        return $request->all();
    }

~~~~

Actually this is a test function that we created but we will change it soon


Step 4: Add a route to the web.php to send request to the ImageController

~~~~

Route::get('upload', 'ImageController@upload')->name('upload');

As you noticed here whenever the request is comes to this route it will sent to the upload function in the ImageController. Also we used here ->name('upload') attribute to make it global. That means inthe application in anyhwere we can {{route('upload')}} so that means the target route wil be this Route::get('upload'.....)

~~~~

Step 5: Lets make some changes on the upload function

Let me put all the code here so we can see how actually its looks like for now, later on we will change as well

~~~~

    public function upload(Request $request){
        
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

        return 'done';
    }
~~~~

Step 6: Lets create an ImageRequest instead of normal Request we will use ImageRequest to validate the request

Here guys we will use the following command to create a new Request Type which going to be used for Images

~~~~

php artisan make:request ImageRequest

~~~~

Basically it will create an request type for use and its name is going to be the ImageRequest so we can use this to validate the request.

Step 7: Lets customize the our custom Request

Go to the ImageRequest.php to add those

~~~~

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'image' => 'required',
        ];
    }
~~~~

Basically here we said 'image' validation is required;

Step 8: Lets change the request type in the ImageController @upload function

Add those lines to the ImageController.php

~~~~

First we have to add our request type path to the here

use App\Http\Requests\ImageRequest;

Now we can use it,

public function upload(ImageRequest $request){ ..... }

~~~~

Basically whenever a request comes to the upload function in the ImageController it will go to the ImageRequest and the request will be validated. If the validation result is false then it will return the errors and it will redirect to the same page (app.blade.php) again.

So How can we see the errors? If there is an error laravel automatically creates an array called errors and puts all the error to this array.

Step 9: Add @if statement to the app.blade.php to see the auto generated $errors arrays data 

~~~~

@if(count($errors))
	@foreach($errors->all() as $error)
		<span class="text-danger">{{$error}}</span>
	@endforeach
@endif

~~~~

If there is an error this code will show the errors in the app.blade.php - [Link](../resources/views/app.blade.php)

