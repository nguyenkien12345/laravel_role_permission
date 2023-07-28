<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RoleRequest extends FormRequest
{
     public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name'          => 'required|min:2|max:255',
            'display_name'  => 'required|min:2|max:255',
            'permissions'   => 'required'
        ];
    }


	public function messages()
    {
        return [
			'required' => 'Vui lòng nhập trường :attribute',
			'min' => ':attribute không được nhỏ hơn :min ký tự',
			'max' => ':attribute không được lớn hơn :max ký tự',
        ];
    }

    public function attributes()
    {
        return [
			'name' => 'Tên giá trị',
			'display_name' => 'Tên hiển thị',
			'permissions' => 'Quyền',
        ];
    }
}
