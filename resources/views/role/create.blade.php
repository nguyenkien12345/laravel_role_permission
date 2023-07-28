@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <h1 class="text-center mx-5">ROLE</h1>
                <form method="POST" action="{{ route('roles.store') }}" enctype="multipart/form-data" novalidate>
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
                        <input type="text" class="form-control" name="name" id="name" placeholder="Enter Name: " value="{{ old('name') }}">
                        @error('name')
                            <span class="btn btn-outline-danger fw-bolder my-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group my-2">
                        <label for="display_name">Display Name</label>
                        <input type="text" class="form-control" name="display_name" id="display_name" placeholder="Enter Display Name: " value="{{ old('display_name') }}">
                        @error('display_name')
                            <span class="btn btn-outline-danger fw-bolder my-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group my-2">
                        <label for="description">Description</label>
                        <textarea class="form-control" name="description" id="description" placeholder="Enter Description: " value="{{ old('description') }}" rows="10" cols="50"></textarea>
                    </div>

                    <div class="form-group my-2">
                        @foreach ($permissionList as $permission)
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="permissions[]" id="permissions" value="{{ $permission->id }}" />
                                <label class="form-check-label">{{ $permission->display_name }}</label>
                            </div>
                        @endforeach
                        @error('permissions')
                            <span class="btn btn-outline-danger fw-bolder my-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-secondary w-100 fw-bold font-medium p-1 text-white fs-5" id="btn-save">Save</button>
                </form>
            </div>
        </div>
    </div>
@endsection
