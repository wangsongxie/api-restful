<?php

namespace App\Http\Requests;

use App\Api\Request\RestRequest;
use Illuminate\Foundation\Http\FormRequest;

class UserRegisterRequest extends RestRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'mobile'           => 'sometimes|required|mobile|unique:users',
            'password'             => 'required',
            'code'                 => 'sometimes|required|regex:/\d{6}/',

        ];
    }

    public function messages()
    {
        return [
            'mobile.unique'                 => '手机号已存在',
            'mobile.mobile'                 => '手机号格式错误',
            'code.required'                 => '验证码不能为空',
            'code.regex'                    => '验证码格式错误',
            'password.required'             => '密码必须填写',
        ];
    }
}
