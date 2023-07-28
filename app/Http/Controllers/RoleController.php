<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use App\Models\Permission;
use DB;
use App\Http\Requests\RoleRequest;

class RoleController extends Controller
{
    private $role;
    private $permission;

    public function __construct(Role $role, Permission $permission)
    {
        $this->role = $role;
        $this->permission = $permission;
    }

    public function index()
    {
        $roleList = $this->role->all();
        return view('role.index', \compact('roleList'));
    }

    public function create()
    {
        $permissionList = $this->permission->all();
        return view('role.create', \compact('permissionList'));
    }

    public function store(RoleRequest $request)
    {
        try {
            DB::beginTransaction();

            // Insert data to role table
            $newRole = $this->role->create([
                'name' => $request->name,
                'display_name' => $request->display_name,
                'description' => $request->description ? $request->description : "",
            ]);

            // Insert data to permission_role table
            $permissions = $request->permissions;
            // Cách 1
            // foreach($permissions as $permission_id){
            //     DB::table('permission_role')->insert([
            //         'role_id' => $newRole->id,
            //         'permission_id' => $permission_id,
            //     ]);
            // }

            // Cách 2
            // Role có quan hệ nhiều nhiều với Permission nên ta chỉ từ 1 trong 2 đối tượng Role hoặc Permission
            // gọi đến đối tượng kia với method belongsToMany hoặc hasMany thì khi dùng attach chúng ta
            // sẽ dựa vào 2 model này lấy ra id của chúng và đưa vào bảng trung gian
            $newRole->permissions()->attach($permissions);

            DB::commit();
            return \redirect()->route('roles');
        } catch (\Exception $exception) {
            DB::rollBack();
        }
    }

    // (Controller nhận vào tham số là id thì Route phải khai báo là id (id của Route trùng với id của Controller)
    public function edit($id)
    {
        $roleList = $this->role->all();
        $permissionList = $this->permission->all();
        // Get Role
        $role = $this->role->find($id);
        // Get Permissions Of Role
        $permissionsOfRole = DB::table('permission_role')->where('role_id', $id)->pluck('permission_id');
        return view('role.edit', \compact('roleList', 'permissionList', 'role', 'permissionsOfRole'));
    }

    // (Controller nhận vào tham số là id thì Route phải khai báo là id (id của Route trùng với id của Controller))
    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();

            // Get Role
            $role = $this->role->find($id);
            // Update data to role table
            $role->update([
                'name' => $request->name,
                'display_name' => $request->display_name,
                'description' => $request->description,
            ]);

            $permissions = $request->permissions;

            // Delete old data in permission_role table
            DB::table('permission_role')->where('role_id', $id)->delete();
            // Add new data/exists data to permission_role table
            $role->permissions()->attach($permissions);

            DB::commit();
            return \redirect()->route('roles');
        } catch (\Exception $exception) {
            DB::rollBack();
        }
    }

    // (Controller nhận vào tham số là id thì Route phải khai báo là id (id của Route trùng với id của Controller))
    public function delete($id)
    {
        try {
            DB::beginTransaction();

            // Get Role
            $role = $this->role->find($id);
            // Delete Role in role table
            $role->delete();

            // Delete permission of role in permission_role table and user of role_user
            $role->permissions()->detach();
            $role->users()->detach();
            DB::commit();
            return \redirect()->route('roles');
        } catch (\Exception $exception) {
            DB::rollBack();
        }
    }
}
