<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use DB;
use App\Models\User;

class CheckPermissionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */

    //  Lấy ra các permission của user đối chiếu với permission của từng route nhận về thông qua tham số permission của middleware để quyết định
    //  user có được phép truy cập hay không ?
    public function handle(Request $request, Closure $next, $permission = null)
    {
        // Lấy ra tất cả các role của user khi user đăng nhập vào hệ thống
        // Cách viết 1
        // $listRoleOfUser = DB::table('users')
        // ->join('role_user', 'users.id', '=', 'role_user.user_id')
        // ->join('roles', 'role_user.role_id', '=', 'roles.id')
        // ->where('users.id', auth()->id())
        // ->select('roles.*')
        // ->pluck('id')->unique()->toArray();

        // Cách viết 2
        $listRoleOfUser = User::find(auth()->id())->roles()->select('roles.id')->pluck('id')->toArray();
        // dd($listRoleOfUser);

        // Lấy ra tất cả các permission của các role đó khi user đăng nhập vào hệ thống
        $listPermissionOfRole = DB::table('roles')
        ->join('permission_role', 'roles.id', '=', 'permission_role.role_id')
        ->join('permissions', 'permission_role.permission_id', '=', 'permissions.id')
        ->whereIn('roles.id', $listRoleOfUser)
        ->select('permissions.*')
        ->pluck('id')->unique();
        // dd($listPermissionOfRole);

        // Lấy ra id của permission của route mà ta nhận về thông qua middleware
        $checkPermission = DB::table('permissions')->where('name', $permission)->value('id');
        // dd($checkPermission);

        // Kiểm tra xem các id permission của user đó có bao gồm id permission của route để được phép truy cập hay không
        if($listPermissionOfRole->contains($checkPermission)){
            return $next($request);
        }
        else{
            // Để trả ra giao diện thì ta cần vào resources/views tạo 1 folder errors (bắt buộc đặt tên là errors) đặt tên file là 401.blade.php (tên file lấy theo mã lỗi trả ra)
            return \abort(401);
        }
    }
}
