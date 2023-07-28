<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Permission;

class PermissionController extends Controller
{
    private $permission;

    public function __construct(Permission $permission){
        $this->permission = $permission;
    }

    public function index(){
        $permissionList = $this->permission->all();
        return view('permission.index', \compact('permissionList'));
    }

    public function create(){
        return view('permission.create');
    }

    public function store(){

    }
}
