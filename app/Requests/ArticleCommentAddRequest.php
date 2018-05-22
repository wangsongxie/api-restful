<?php

namespace App\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ArticleCommentAddRequest extends FormRequest
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
            'article_id' => 'required|integer|exists:articles,id',
            'content' => 'required'
        ];
    }

    public function messages()
    {
        return [
            "article_id.required" => '请选择文章id',
            "article_id.integer" => '文章id类型为整型',
            "article_id.exists" => '文章不存在',
            "content.required" => '评论内容不能为空',
        ];
    }
}
