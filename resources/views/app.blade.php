<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <meta name="csrf-token" content="{{csrf_token()}}">
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
</head>

<body>

    <div id="app"><br>
        <div class="container col-lg-offset-4 col-lg-4">
            <div class="row">
                <!-- Whenever submit button clicked the request will sent to the route /upload
                as you noticed that here we didn't write action="/uplaod" instead we use route('upload')
                we could use this because in web.php we had give ->name('upload') to the our route
             -->@if(count($errors))
                    @foreach($errors->all() as $error)
                        <span class="text-danger">{{$error}}</span>
                    @endforeach
                @endif
                <form action="{{route('upload')}}" enctype="multipart/form-data" method="post">
                    @csrf
                    <input type="file" name="image">
                    <img src="/sarthak.jpg" alt="Image">
                    <input type="submit" class="btn btn-success" value="upload">
                </form>
            </div>
        </div>
    </div>

    <script src="{{asset('js/app.js')}}"></script>
</body>

</html>