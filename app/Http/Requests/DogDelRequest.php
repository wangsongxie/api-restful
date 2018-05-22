<?php

namespace App\Http\Requests;

use App\Api\Request\RestRequest;
use Illuminate\Foundation\Http\FormRequest;

class DogDelRequest extends RestRequest
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
            'dog_ids'            => 'required|array',
            'dog_ids.*'            => 'required|integer',

        ];
    }

    public function messages()
    {
        return [
            "dog_ids.required"            => '删除狗狗不能为空',
            "dog_ids.*.integer"           => '删除狗狗ID类型不正确',

        ];
    }
}
