<?php

namespace App\Http\Requests;

use App\Api\Request\RestRequest;

class OrderRequest extends RestRequest
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
            "dog_id"        => "required|regex:/[0-9]+/",
            "address_id"    => "required|regex:/[0-9]+/",
            "payment"       => "required|in:weixin,alipay",
            "shipping_type" => "required|in:0,1,2",
        ];
    }

    public function messages()
    {
        return [
            "dog_id.required"        => "商品不能为空",
            "dog_id.regex"           => "商品编号错误",
            "address_id.required"    => "地址不能为空",
            "address_id.regex"       => "地址编号错误",
            "payment.required"       => "请选择支付方式",
            "payment.in"             => "支付方式选择不正确",
            "shipping_type.required" => '请选择配送方式',
            "shipping_type.in"       => "配送方式不正确",
        ];
    }
}
