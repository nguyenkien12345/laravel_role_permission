<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use Hash;
use DB;
use App\Http\Requests\UserRequest;

class UserController extends Controller
{
    private $user;
    private $role;

    public function __construct(User $user, Role $role){
        $this->user = $user;
        $this->role = $role;
    }

    public function index(){
        $userList = $this->user->all();
        return view('user.index', \compact('userList'));
    }

    public function create(){
        $roleList = $this->role->all();
        return view('user.create', \compact('roleList'));
    }

    public function store(UserRequest $request){
        try{
            DB::beginTransaction();

            // Insert data to user table
            $newUser = $this->user->create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            // Insert data to role_user table
            $roles = $request->roles;
            // Cách 1
            // foreach($roles as $role_id){
            //     DB::table('role_user')->insert([
            //         'user_id' => $newUser->id,
            //         'role_id' => $role_id,
            //     ]);
            // }

            // Cách 2
            // User có quan hệ nhiều nhiều với Role nên ta chỉ từ 1 trong 2 đối tượng User hoặc Role
            // gọi đến đối tượng kia với method belongsToMany hoặc hasMany thì khi dùng attach chúng ta
            // sẽ dựa vào 2 model này lấy ra id của chúng và đưa vào bảng trung gian
            $newUser->roles()->attach($roles);

            DB::commit();
            return \redirect()->route('users');
        }
        catch(\Exception $exception){
            DB::rollBack();
        }
    }

    // (Controller nhận vào tham số là id thì Route phải khai báo là id (id của Route trùng với id của Controller)
    public function edit($id){
        $roleList = $this->role->all();
        // Get User
        $user = $this->user->find($id);
        // Get Roles Of User
        $rolesOfUser = DB::table('role_user')->where('user_id', $id)->pluck('role_id');
        return view('user.edit', \compact('roleList', 'user', 'rolesOfUser'));
    }

    // (Controller nhận vào tham số là id thì Route phải khai báo là id (id của Route trùng với id của Controller))
    public function update(Request $request, $id){
        try{
            DB::beginTransaction();

            // Get User
            $user = $this->user->find($id);
            // Update data to user table
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
            ]);

            $roles = $request->roles;

            // Delete old data in role_user table
            DB::table('role_user')->where('user_id', $id)->delete();
            // Add new data/exists data to role_user table
            $user->roles()->attach($roles);

            DB::commit();
            return \redirect()->route('users');
        }
        catch(\Exception $exception){
            DB::rollBack();
        }
    }

    // (Controller nhận vào tham số là id thì Route phải khai báo là id (id của Route trùng với id của Controller))
    public function delete($id){
        try{
            DB::beginTransaction();

            // Get User
            $user = $this->user->find($id);
            // Delete User in user table
            $user->delete();

            // Delete roles of user in role_user table
            $user->roles()->detach();

            DB::commit();
            return \redirect()->route('users');
        }
        catch(\Exception $exception){
            DB::rollBack();
        }
    }
}
