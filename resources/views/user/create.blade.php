@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <h1 class="text-center mx-5">USER</h1>
                <form method="POST" action="{{ route('users.store') }}" enctype="multipart/form-data" novalidate>
                    @csrf

                    {{--
                    @if ($errors->any())
                        <div class="btn btn-outline-danger fw-bolder w-100">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    --}}

                    <div class="form-group my-2">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" name="name" id="name" placeholder="Enter Your Name" value="{{ old('name') }}">
                        @error('name')
                            <span class="btn btn-outline-danger fw-bolder my-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group my-2">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" name="email" id="email" placeholder="Enter Your Email" value="{{ old('email') }}">
                        @error('email')
                            <span class="btn btn-outline-danger fw-bolder my-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group my-2">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" name="password" id="password" placeholder="Enter Your Password" value="{{ old('password') }}">
                        @error('password')
                            <span class="btn btn-outline-danger fw-bolder my-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group my-2">
                        <label for="password_confirmation">Confirm Password</label>
                        <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" placeholder="Enter Your Confirm Password" value="{{ old('password_confirmation') }}">
                        @error('password_confirmation')
                            <span class="btn btn-outline-danger fw-bolder my-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group my-2">
                        <label for="roles">Role</label>
                        <select class="form-control" name="roles[]" id="roles" multiple value="{{ old('roles[]') }}">
                            @foreach ($roleList as $role)
                                <option value="{{$role->id}}">{{$role->display_name}}</option>
                            @endforeach
                        </select>
                        @error('roles')
                            <span class="btn btn-outline-danger fw-bolder my-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-secondary w-100 fw-bold font-medium p-1 text-white fs-5" id="btn-save">Save</button>
                </form>
            </div>
        </div>
    </div>
@endsection
