@extends('layouts/app')

@section('content')
    <div class="container">
        <form class="px-4 bg-primary rounded-4 py-3 text-white" action="/users/{{$user->id}}" method="post" enctype="multipart/form-data">
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
            <p class="fs-3 fw-bold text-white">Update {{$user->name}} profile info</p>
            <div class="mt-3 input-group">
                <label for="name_inp" class="input-group-text">User Name</label>
                <input id="name_inp" type="text" name="name" required class="form-control" value="{{$user->name}}">
            </div>
            <div class="mt-3 input-group">
                <label for="email_inp" class="input-group-text">Email</label>
                <input id="email_inp" type="email" name="email" required class="form-control" value="{{$user->email}}">
            </div>
            <div class="mt-3">
                <label for="desc_inp" class="form-label">Description</label>
                <textarea id="desc_inp" type="file" name="description" required class="form-control">
                    {{$user->description}}
                </textarea>
            </div>
            <div class="mt-3 input-group">
                <label for="role_select" class="input-group-text">User role</label>
                <select id="role_select" name="role_id" required class="form-select" value="{{$user->role_id}}">
                    @foreach($roles as $role)
                        @if($role->id === $user->role_id)
                            <option value="{{$role->id}}" selected>{{$role->name}}</option>
                        @else
                            <option value="{{$role->id}}">{{$role->name}}</option>
                        @endif
                    @endforeach
                </select>
            </div>
            <div class="mt-3 input-group">
                <input id="img_inp" type="file" name="user_image" class="form-control">
            </div>
            <div class="mt-3 d-flex justify-content-center">
                <button class="btn btn-light">Update your info</button>
            </div>
        </form>
    </div>
    @include('tiny_text_editor')
@endsection
