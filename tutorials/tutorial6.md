# How to Upload Image to the public Folder Instead of DB?

Step 1: Lets Create 2 Different Routes In web.php to use to upload image to the public folder

So we will create 2 routes as named as following:

~~~~

// With.save.image
Route::view('saveImage', 'showSaveImage');
Route::post('saveImage','ImageController@saveImage');

~~~~

Route::view('saveImage') will be used to show the layout as name as showSaveImage.
Route::post('saveImge') will be used to save the image to the public folder by sending request to the ImageController.php and saveImage function..

Step 2: Go and Create 1 Layout & 1 Custom Component For Image Upload

So we gonna create a layout called **showSaveImage.blade.php** in the resources/views and i will put the all code that we already wrote before in the **home.blade.php** as follows:

~~~~

@extends('layouts.app') 

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif

                    <div id="app"><br>
                        <div class="container col-lg-offset-4 col-lg-4">
                            <div class="row">
                                <!-- Whenever submit button clicked the request will sent to the route /upload
                                    as you noticed that here we didn't write action="/uplaod" instead we use route('upload')
                                     we could use this because in web.php we had give ->name('upload') to the our route
                                 -->            
                                @if(count($errors)) 
                                    @foreach($errors->all() as $error)
                                        <span class="text-danger">{{$error}}</span>
                                    @endforeach 
                                @endif
                                <upload-form :user="{{auth()->user()}}"></upload-form>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

~~~~

Later on we will create another component called SaveImage.vue to save the Image to the public folder, to this folder we will put the same code that we aldready wrote in the **UploadForm.vue** as follows:

~~~~

<template>
    <!-- <form action="{{route('upload')}}" enctype="multipart/form-data" method="post">
        @csrf -->
    <div>
        <input type="file" name="image" @change="GetImage">
        <img :src="avatar" alt="Image" class="img-fluid">
        <a href="#" v-if="loaded" class="btn btn-success" @click.prevent="upload">Upload</a>
        <a href="#" v-if="loaded" class="btn btn-danger" @click.prevent="cancel">Cancel</a>
    </div>
    <!-- </form> -->
</template>

<script>
    export default {
        props: ['user'], //can accept this variable from the component tags <upload-form :user="{{auth()->user()}}">

        data() {
            return {
                avatar: `storage/${this.user.image}`,
                loaded: false,
                file: null,
            }
        },

        methods: {

            GetImage(e) {
                let image = e.target.files[0];
                this.read(image); //to put image to image tag
                let form = new FormData(); //javascript data
                form.append('image',image);
                this.file = form;
                console.log(this.file);
            },

            upload() {
                axios.post('/saveImage', this.file).then(() => {
                    this.$toasted.show('Avatar is Uploaded!', {
                        type: 'success',
                    }),
                    this.loaded = false;
                });
            },

            read(image) {
                let reader = new FileReader();
                reader.readAsDataURL(image);
                console.log("Reader: " + reader);
                reader.onload = (res) => {
                    console.log("Res: " + res);
                    this.avatar = res.target.result
                }
                this.loaded = true;
            },

            cancel() {
                this.avatar = this.user.avatar;
                this.loaded = false;
            }
        }
    }
</script>

~~~~

In this component the template is same as the **UploadForm.vue** component but we have changed some code in the script. Because this time we do not want to conver the image to the base64 format instead we want to send the image to the public folde and in the database record the image name.

So this purpose, in the data() function we have created another variable called file and its initial value is null.

In the GetImage() function we have created another variable called form which holds the instance of the FormData(). FormData() is an object type is comes built-in in the javascript. So to the this variable we will append the image which we already took on the selected image tag.

And later we said this.file is equal to the form which we created in data() function.

In the upload() function while we sending the request we are gonna send the file as well to the /saveImage url.

Step 3: Lets create a function in the ImageController.php as called as saveImage().

So in this function we will create the algorithm that puts the sended file to the public folder of the application

Lets add those codes.

~~~~

    public function saveImage(ImageRequest $request) {
        
            if($request->hasFile('image')){
            //$request->image->store('public');
            //it will store the image to the store/public folder with an something ver long encrypted name
            //But we need to save the file with an original name so we need to use following code
            $imagename = $request->image->getClientOriginalName(); //this is as built-in function in UploadedFile.php (check more), gets the original name of the file
            $request->image->storeAs('public', $imagename);
            $request->user()->update(['image' => $imagename]);
            return response(null, 202);
        }
    }

~~~~

This function is pretty much as same as the before we have done.



