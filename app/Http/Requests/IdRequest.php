<?php

namespace App\Http\Requests;

use App\Api\Request\RestRequest;
use Illuminate\Foundation\Http\FormRequest;

class IdRequest extends RestRequest
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
            "id" => "regex:/[0-9]+/"
        ];
    }

    public function messages()
    {
        return [
            "id.regex" => "id格式错误",
        ];
    }
}
