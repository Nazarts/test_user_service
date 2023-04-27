@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center justify-content-md-start flex-wrap gy-3">
        @foreach($users as $user)
            <div class="col-12 col-sm-10 col-md-4">
                <div class="card h-100">
                    <img src="{{URL::to('/images').'/'.$user->user_image}}" class="card-img-top" alt="...">
                    <div class="card-body d-flex flex-column justify-content-between gap-2">
                        <div>
                            <h5 class="card-title">{{$user->name}}</h5>
                            <p class="card-text mb-2 text-info">{{$user->role_name}}</p>
                            <p class="card-text fw-semibold">Joined: {{$user->created_at}}</p>
                        </div>
                        <div>
                            <a href="/users/{{$user->id}}" class="btn btn-primary">Show more</a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <div class="mt-4">
        {{ $users->links() }}
    </div>
</div>
@endsection
