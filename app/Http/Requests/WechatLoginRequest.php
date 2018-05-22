<?php

namespace App\Http\Requests;

use App\Api\Request\RestRequest;

class WechatLoginRequest extends RestRequest
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
//        dd(request()->all());
        return [
            'code'               => 'required',

        ];
    }

    public function messages()
    {
        return [
            "code.required"               => 'code不能为空',
        ];
    }
}
