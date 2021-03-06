<?php

namespace App\Http\Requests;

use App\Api\Request\RestRequest;
use Illuminate\Foundation\Http\FormRequest;

class UpdateAddressRequest extends RestRequest
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
            'id' => 'required|integer|exists:address',
            'region_id' => 'required|numeric',
            'is_default'  => 'required|in:0,1',
            'address'     => 'required',
            'username'    => 'required',
            'mobile'      => 'required|mobile',
        ];
    }

    public function messages()
    {
        return [
            "id.required" => '请选择修改地址ID',
            "id.integer" => 'ID格式不正确',
            "id.exists" => '地址不存在',
            "region_id.required" => '请选择地区',
            'address.required'     => '详细地址错误',
            'username.required'    => '请填写用户名',
            'mobile.required'      => '请填写手机号',
            'is_default.required'  => '是否默认错误',
            'is_default.in'        => '是否默认错误',
        ];
    }
}
