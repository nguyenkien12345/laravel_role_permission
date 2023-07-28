@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 mx-3 p-1 w-100">
                <a href="{{ route('permissions.create') }}" class="btn btn-success fw-semibold" id="btn-add"> Add Permission </a>
            </div>

            <div class="col-12">
                <h1 class="text-center mx-5">PERMISSION MANAGERMENT</h1>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">STT</th>
                            <th scope="col">Name</th>
                            <th scope="col">Mô tả</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($permissionList as $permission)
                            <tr>
                                <th scope="row">{{ $loop->index++ }}</th>
                                <td>{{ $permission->display_name }}</td>
                                <td>{{ $permission->description }}</td>
                                <td>
                                    <a href="" class="btn btn-primary" id="btn-edit"> Edit </a>
                                    <a href="" class="btn btn-danger"  id="btn-delete"> Delete </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
