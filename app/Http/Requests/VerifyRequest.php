<?php

namespace App\Http\Requests;

use App\Api\Request\RestRequest;

class VerifyRequest extends RestRequest
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
            'sell_type'         => 'required|in:1,2',
            'mobile'            => 'required|mobile',
            'real_name'         => 'required|max:5',
            'id_card'           => 'required|size:18',
            'id_card_image'     => 'required',
            'address'           => 'required',
            'bank_name'         => 'required',
            'bank_no'           => 'required',
            'license_image_url' => 'sometimes|required',
            'shop_name'         => 'sometimes|required',
            'lon'               => 'sometimes|required',
            'lat'               => 'sometimes|required',
        ];
    }

    public function messages()
    {
        return [
            'sell_type.required'      => '认证类型不能为空',
            'mobile.required'         => '手机号必填',
            'mobile.mobile'           => '手机号格式错误',
            'username.required'       => '姓名必填',
            'id_card.required'         => '身份证必填',
            'id_card.size'             => '身份证格式错误',
            'id_card_image.required'  => '身份证照片必填',
            'address.required'        => '地址必填',
            'bank_name.required'      => '银行必填',
            'bank_no.required'        => '银行账号必填',
            'license_image_url.required' => '营业执照必填',
            'shop_name.required'      => '店铺名称必填',
        ];
    }
}
