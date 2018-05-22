<?php

namespace App\Http\Requests;

use App\Api\Request\RestRequest;
use Illuminate\Validation\Rule;

class UpdateUserInfoRequest  extends RestRequest
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
        $id = \Auth::user()->id;
        return [
            'user_info' => 'required',
            'user' => 'required',
            'user_info.headimgurl'              => 'sometimes|required',
            'user_info.nickname'                => 'sometimes|between:1,10',
            'user_info.first_keep_pets_time'    => 'sometimes|required|date',
            'user_info.real_name'               => 'sometimes|required|between:1,10',
            'user_info.sex'                     => 'sometimes|required|in:0,1,2',
            'user_info.birthday'                => 'sometimes|required|date',
            'user.email'                        => 'sometimes|required|email',
            'user.code'                         => 'sometimes|required|regex:/\d{6}/',
//            'user.mobile'                       => "sometimes|required|mobile|unique:users,mobile,{$id}",
            'user.mobile'                       => [
                'sometimes',
                'required',
                'mobile',
                Rule::unique('users', 'mobile')->ignore(\Auth::user()->id, 'id')
            ],
        ];
    }

    public function messages()
    {
        return [
            'user_info.headimgurl.required'           => '头像地址必填',
            'user_info.nickname.required'             => '昵称必填',
            'user_info.first_keep_pets_time.required' => '首次养宠时间必填',
            'user_info.real_name.required'            => '真实姓名必填',
            'user_info.sex.required'                  => '性别必填',
            'email.required'                          => '邮箱必填',
            'user_info.nickname.between'              => '昵称1-10个字符',
            'user_info.first_keep_pets_time.date'     => '首次养宠时间必须为日期',
            'user_info.real_name.between'             => '真实姓名1-10个字符',
            'user.mobile.unique'                      => '手机号已存在',
            'user.mobile.mobile'                      => '手机号格式错误',
            'user.name.required'                      => '登录名不能为空',
        ];
    }
}
