# How to Upload Image in base64 Format to the Db

As you remember last tutorial we have created our custom UploadForm component. 

In the component we have to make few changes.

Step 1: Lets add @change event to the input and whenever user select a image show it in the image tag

We have to add an attribute to the input field as follows:

~~~~

<input type="file" name="image" @change="GetImage">

~~~~

@change is an vue event so that means whenever a change is happened on this element it will call the function defined in the @change as like as we did. So whenever user want to upload an item and select it it will call the GetImage function.

Step 2: Implement GetImage function in **script** tag

As you know, the custom components can have functions in methods : { } object so lets create a function called GetImage in the methods object.

~~~~

            GetImage(e) {
                let image = e.target.files[0]; //name of the iöage
                let reader = new FileReader(); 
                reader.readAsDataURL(image);
                console.log("Reader: " + reader);
                reader.onload = (res) => {
                    console.log("Res: " + res);
                    this.avatar = res.target.result
                }
            },
~~~~

Step 3: Lets make some changes in ImageController.php, we need to change the upload() function a little.

~~~~

    public function upload(ImageRequest $request){
        
        //image is the name of the field thas has been written in app.blade.php
        /*if($request->hasFile('image')){
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
        //}

        $request->user()->avatar = $request->image;
        $request->user()->save();
        return response(null,200);
    }

~~~~

We want to get the image name from the request so we wrote $request->user()->avatar = $request->image;

Step 4: We want to get the image from the db when user logged in so we need to make a little changes on UploadForm.vue component

~~~~

        <img :src="avatar" alt="Image">

~~~~

We added :src attribute to the image that means it will get the avatar variables data.

Step 5: How to put real image to the avatar.data

We have to add this line to the **script** tag

~~~~

        props: ['user'], //can accept this variable from the component tags <upload-form :user="{{auth()->user()}}">

        data() {
            return {
                avatar: this.user.avatar,
            }
        },

~~~~

Step 6: How to sent data to the image from the **upload-form** tag

We have to add this line to the upload-form tag to sent the user image from db

~~~~

<upload-form :user="{{auth()->user()}}"></upload-form>

~~~~

So whenever this component is loaded it will sent the user data to the back side.