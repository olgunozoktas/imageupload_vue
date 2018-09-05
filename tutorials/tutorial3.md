# How to Show User Image After Logged In?

Step 1: Create Authentication Files using default laravel auth

~~~~

php artisan make:auth

~~~~

This will create an authentication files in resouces/views/

Later on copy the all elements from app.blade.php and put them to the home.blade.php as follows:

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
                                <upload-form></upload-form>
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

You may asked that whappened to the form element? and why do we have **upload-form** tags in here?

Basically because we created an custom vue component

Step 2: Lets create the custom vue component

Go to the resources/assets/js/components folder and create a file called UploadForm.vue

.vue is the extension of the vue type files.

And into the file add those lines

~~~~

<template>
    <!-- <form action="{{route('upload')}}" enctype="multipart/form-data" method="post">
        @csrf -->
    <div>
        <input type="file" name="image">
        <img src="" alt="Image">
        <a href="#" class="btn btn-success" @click.prevent="upload">Upload</a>
    </div>
    <!-- </form> -->
</template>

<script>
    export default {
        methods: {
            upload() {
                axios.post('/upload');
            }
        }
    }
</script>

~~~~

We commented the form tags because we will no longer need them to send request to the /upload. 
In detail, as you can see we have added @click.pevent and bootstraps btn classes  to the **a** tag and wehenever we clicked that **button** because it will be look like to green success button then it will try to send to the request to the /upload url by using the function called upload() in the **script** tags. Because we added ="upload" function to the click event. Another important things is here it will not reload or redirect the page because we are using here javascrip.

Step 3: Add the component to the app.js which is the main javascript file works in the application

There are other ways to add a component but we will use import way so lets add those lines to the app.js

~~~~

import uploadForm from "./components/uploadForm";

const app = new Vue({
    el: "#app",
    components: { uploadForm }
});

~~~~

app.js is the in the resources/assets/js folder and there is another which is called components. And as you remember we have created our component in this folder thats why we wrote import uploadForm from './components/uploadForm'; 

Basically it will get this component.

and then we have added to the app object as an components: { uploadForm }

So that means if we use **upload-form** tags in the html tags which has id app then it will be placed there.