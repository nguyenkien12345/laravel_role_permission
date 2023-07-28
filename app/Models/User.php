<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Role;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // QUAN HỆ N-N
    // 1 User có thể có nhiều Role / thuộc nhiều role
    // (Nên dùng belongsToMany để khi dùng attach/detach/async sẽ thay đổi dữ liệu bảng trung gian role_user)
    public function roles(){
        return $this->belongsToMany(Role::class);
    }
}
