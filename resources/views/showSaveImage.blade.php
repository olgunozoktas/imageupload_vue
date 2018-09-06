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
                                <save-image :user="{{auth()->user()}}"></save-image>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection