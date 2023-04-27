@extends('layouts/app')

@section('content')
    <div class="container">
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
        @if(Auth::user()->role_name->name === 'Admin')
            <div class="d-flex mt-3 gap-4">
                <a class="btn btn-dark" href="/users/{{$user->id}}/edit">Update user</a>
                <form method="post" class="" action="/users">
                    @csrf
                    @method('delete')
                    <input name="user_id" type="hidden" value="{{$user->id}}">
                    <button class="btn btn-danger">Delete user</button>
                </form>
            </div>
        @endif
        <a class="btn btn-primary mt-3" href="/">< Back</a>
    </div>
@endsection
