<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Permission;

class Role extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'display_name',
        'description',
    ];

    // QUAN HỆ N-N
    // 1 Role có thể có nhiều User / thuộc nhiều User
    public function users(){
        return $this->belongsToMany(User::class);
    }

    // 1 Role có thể có nhiều Permission / thuộc nhiều Permission
    public function permissions(){
        return $this->belongsToMany(Permission::class);
    }
}
