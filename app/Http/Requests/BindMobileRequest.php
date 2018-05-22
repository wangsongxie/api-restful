<?php

namespace App\Http\Requests;

use App\Api\Request\RestRequest;
use Illuminate\Foundation\Http\FormRequest;

class BindMobileRequest extends RestRequest
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
            'mobile' => 'required|mobile',
            'mobile_code' => 'required|regex:/\d{6}/',
            'code' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'mobile.required' => '请填写手机号',
            'mobile.mobile' => '手机号格式错误',

            'mobile_code.required' => '请输入验证码',
            'mobile_code.regex' => '验证码格式不正确',

            'code.required' => '请输入绑定code',
        ];
    }
}
