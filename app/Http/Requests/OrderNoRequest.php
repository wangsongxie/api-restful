<?php

namespace App\Http\Requests;

use App\Api\Request\RestRequest;

class OrderNoRequest extends RestRequest
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
            "order_no"        => "required|exists:orders,order_no",
        ];
    }

    public function messages()
    {
        return [
            "order_no.required"        => "订单号不能为空",
            "order_no.exists"           => "订单不存在",
        ];
    }
}
