@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 mx-3 p-1 w-100">
                <a href="{{ route('roles.create') }}" class="btn btn-success fw-semibold" id="btn-add"> Add Role </a>
            </div>

            <div class="col-12">
                <h1 class="text-center mx-5">ROLE MANAGERMENT</h1>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">STT</th>
                            <th scope="col">Name</th>
                            <th scope="col">Display Name</th>
                            <th scope="col">Description</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($roleList as $role)
                            <tr>
                                <th scope="row">{{ $loop->index + 1 }}</th>
                                <td>{{ $role->name }}</td>
                                <td>{{ $role->display_name }}</td>
                                <td>{{ $role->description }}</td>
                                <td>
                                    <a href="{{ route('roles.edit', ['id' => $role->id]) }}" class="btn btn-primary" id="btn-edit"> Edit </a>
                                    <a href="{{ route('roles.delete', ['id' => $role->id]) }}" class="btn btn-danger"  id="btn-delete"> Delete </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
