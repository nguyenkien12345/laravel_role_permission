<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;
use Illuminate\Support\Facades\DB;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Route::middleware(['auth'])->group(function () {

    Route::prefix('users')->group(function() {
        // Xem danh sách user
        // Bên middleware sẽ nhận về tham số user_list (permission). Nếu user đăng nhập vào cũng có quyền này thì được truy cập vào route này
        Route::get('/', [UserController::class, 'index'])->middleware('checkPermission:user_list')->name('users');

        // Thêm user
        // Bên middleware sẽ nhận về tham số user_add (permission). Nếu user đăng nhập vào cũng có quyền này thì được truy cập vào route này
        Route::get('/create', [UserController::class, 'create'])->middleware('checkPermission:user_add')->name('users.create');
        Route::post('/create', [UserController::class, 'store'])->middleware('checkPermission:user_add')->name('users.store');

        // Cập nhật user (Controller nhận vào tham số là id thì Route phải khai báo là id (id của Route trùng với id của Controller))
        // Bên middleware sẽ nhận về tham số user_edit (permission). Nếu user đăng nhập vào cũng có quyền này thì được truy cập vào route này
        Route::get('/edit/{id}', [UserController::class, 'edit'])->middleware('checkPermission:user_edit')->name('users.edit');
        Route::post('/update/{id}', [UserController::class, 'update'])->middleware('checkPermission:user_edit')->name('users.update');

        // Xóa user (Controller nhận vào tham số là id thì Route phải khai báo là id (id của Route trùng với id của Controller))
        // Bên middleware sẽ nhận về tham số user_delete (permission). Nếu user đăng nhập vào cũng có quyền này thì được truy cập vào route này
        Route::get('/delete/{id}', [UserController::class, 'delete'])->middleware('checkPermission:user_delete')->name('users.delete');
    });

    Route::prefix('roles')->group(function() {
        // Xem danh sách role
        Route::get('/', [RoleController::class, 'index'])->middleware('checkPermission:role_list')->name('roles');

        // Thêm role
        Route::get('/create', [RoleController::class, 'create'])->middleware('checkPermission:role_add')->name('roles.create');
        Route::post('/create', [RoleController::class, 'store'])->middleware('checkPermission:role_add')->name('roles.store');

        // Cập nhật role (Controller nhận vào tham số là id thì Route phải khai báo là id (id của Route trùng với id của Controller))
        Route::get('/edit/{id}', [RoleController::class, 'edit'])->middleware('checkPermission:role_edit')->name('roles.edit');
        Route::post('/update/{id}', [RoleController::class, 'update'])->middleware('checkPermission:role_edit')->name('roles.update');

        // Xóa role (Controller nhận vào tham số là id thì Route phải khai báo là id (id của Route trùng với id của Controller))
        Route::get('/delete/{id}', [RoleController::class, 'delete'])->middleware('checkPermission:role_delete')->name('roles.delete');
    });

    Route::prefix('permissions')->group(function() {
        // Xem danh sách permission
        Route::get('/', [PermissionController::class, 'index'])->name('permissions');

        // Thêm permission
        Route::get('/create', [PermissionController::class, 'create'])->name('permissions.create');
        Route::post('/create', [PermissionController::class, 'store'])->name('permissions.store');
    });

// });

Route::get('min-role-user-permission-role', function () {
    $role_user = DB::table('role_user')->min('user_id');
    $permission_role = DB::table('permission_role')->min('permission_id');
    dd($role_user, $permission_role);
});

Route::get('max-role-user-permission-role', function () {
    $role_user = DB::table('role_user')->max('user_id');
    $permission_role = DB::table('permission_role')->max('permission_id');
    dd($role_user, $permission_role);
});

Route::get('sum-role-user-permission-role', function () {
    $role_user = DB::table('role_user')->sum('user_id');
    $permission_role = DB::table('permission_role')->sum('permission_id');
    dd($role_user, $permission_role);
});

Route::get('avg-role-user-permission-role', function () {
    $role_user = DB::table('role_user')->avg('user_id');
    $permission_role = DB::table('permission_role')->avg('permission_id');
    dd($role_user, $permission_role);
});

Route::get('count-role-user-permission-role', function () {
    $role_user = DB::table('role_user')->count('user_id');
    $permission_role = DB::table('permission_role')->count('permission_id');
    dd($role_user, $permission_role);
});
