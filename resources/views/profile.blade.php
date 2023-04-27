@extends('layouts/app')

@section('content')
    <div class="container py-5">
        <div class="col-10 col-md-8">
            <div>
                <img width="200px" src="{{URL::to('/images').'/'.$user->user_image}}" alt="">
            </div>
            <p class="fs-2 mt-5 fw-semibold">{{$user->name}}</p>
            <p class="text-info fs-5">{{$user->role_name->name}}</p>
            <p class="">Email: <span class="fw-semibold">{{$user->email}}</span></p>
            <p>Description:</p>
            <p class="">{!! $user->description !!}</p>
        </div>
{{--        <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">--}}
{{--            Update your profile info--}}
{{--        </button>--}}
        <div>
            <form class="mt-5 px-4 bg-primary rounded-4 py-3 text-white" action="/profile" method="post" enctype="multipart/form-data">
                @csrf
                @method('put')
                <div>
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
                <p class="fs-3 fw-bold text-white">Update your profile info</p>
                <div class="mt-3 input-group">
                    <label for="name_inp" class="input-group-text">User Name</label>
                    <input id="name_inp" type="text" name="name" required class="form-control" value="{{$user->name}}">
                </div>
                <div class="mt-3 input-group">
                    <label for="email_inp" class="input-group-text">Email</label>
                    <input id="email_inp" type="email" name="email" required class="form-control" value="{{$user->email}}">
                </div>
                <div class="mt-3 input-group">
                    <label for="password_inp" class="input-group-text">Password</label>
                    <input id="password_inp" type="password" name="password" class="form-control" value="{{$user->password}}">
                </div>
                <div class="mt-3">
                    <label for="desc_inp" class="form-label">Description</label>
                    <textarea id="desc_inp" type="file" name="description" required class="form-control">
                    {{$user->description}}
                </textarea>
                </div>
                <div class="mt-3 input-group">
                    <input id="img_inp" type="file" name="user_image" class="form-control">
                </div>
                <div class="mt-3 d-flex justify-content-center">
                    <button class="btn btn-light">Update your info</button>
                </div>
            </form>
        </div>
    </div>
    @include('tiny_text_editor')
@endsection
