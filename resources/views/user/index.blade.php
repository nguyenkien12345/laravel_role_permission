@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 mx-3 p-1 w-100">
                <a href="{{ route('users.create') }}" class="btn btn-success fw-semibold" id="btn-add"> Add User </a>
            </div>

            <div class="col-12">
                <h1 class="text-center mx-5">USER MANAGERMENT</h1>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">STT</th>
                            <th scope="col">Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($userList as $user)
                            <tr>
                                <th scope="row">{{ $loop->index + 1 }}</th>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    <a href="{{ route('users.edit', ['id' => $user->id]) }}" class="btn btn-primary" id="btn-edit"> Edit </a>
                                    <a href="{{ route('users.delete', ['id' => $user->id] ) }}" class="btn btn-danger"  id="btn-delete"> Delete </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
