<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name'        => 'required|min:3|max:255',
            'email'       => 'required|max:255|email',
            'password'    => 'required|min:6|max:255|confirmed',
            'roles'     => 'required', Rule::in(["1", "2", "3"])
        ];
    }


	public function messages()
    {
        return [
			'required' => 'Vui lòng nhập trường :attribute',
			'min' => ':attribute không được nhỏ hơn :min ký tự',
			'max' => ':attribute không được lớn hơn :max ký tự',
            'email' => ':attribute không đúng định dạng',
			'confirmed' => 'Mật khẩu không trùng khớp. Vui lòng kiểm tra lại',
        ];
    }

    public function attributes()
    {
        return [
			'name' => 'Họ và tên',
			'email' => 'Email',
			'password' => 'Mật khẩu',
			'roles' => 'Quyền',
        ];
    }
}
