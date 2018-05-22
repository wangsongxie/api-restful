<?php

namespace App\Http\Requests;

use App\Api\Request\RestRequest;
use Illuminate\Foundation\Http\FormRequest;

class DogUpdateRequest extends RestRequest
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
            'id'                 => 'required|integer|exists:dogs,id',
            "cate_id"            => 'required|integer|exists:dog_categories,id',
            "birthday"           => "required|date",
            "vaccine"            => "required|integer",
            "sex"                => "required|in:1,2",
            "sterilization"      => "required|in:0,1",
            "grade"              => "required|in:0,1",
            "body_size"          => "required|in:0,1,2",
            "insect"             => "required|integer",
            "is_presell"         => "required|in:0,1",
            "health_ensure_days" => "required|integer",
            "title"              => "required|max:50",
            "buyout_price"       => "required|numeric|min:2000",
            "market_price"       => "required|numeric|min:2000",
            "dog_info.detail"    => "required",
            "files"              => "required",
            "files.*.type"         => "required|in:1,2",
            "files.*.url"          => "required",
        ];
    }

    public function messages()
    {
        return [
            "id.required"                 => '狗狗ID不能为空',
            "id.integer"                  => '狗狗ID必须为整型',
            "id.exists"                   => '更新狗狗不存在',
            "cate_id.required"            => '分类不能为空',
            "cate_id.integer"             => '分类必须为整数',
            "cate_id.exists"              => '所选分类不存在',
            "birthday.required"           => '生日不能为空',
            "birthday.date"               => '生日格式错误',
            "vaccine.required"            => "请填写疫苗次数",
            "vaccine.integer"             => "疫苗格式错误",
            "sex.required"                => "请填写宠物性别",
            "sex.in"                      => "性别填写错误",
            "sterilization.required"      => "请填写是否绝育",
            "sterilization"               => "绝育填写错误",
            "grade.required"              => "请填写宠物品级",
            "grade.in"                    => "宠物品级填写错误",
            "body_size.required"          => "请填写宠物体型",
            "body_size.in"                => "宠物体型选择错误",
            "insect.required"             => "请填写驱虫次数",
            "insect.integer"              => "驱虫次数填写错误",
            "is_presell.required"         => "请填写是否是预售",
            "is_presell.in"               => "是否预售填写错误",
            "health_ensure_days.required" => "请填写健康保证日期",
            "health_ensure_days.integer"  => "健康保证填写错误",
            "title.required"              => "请填写标题",
            "title.max"                   => "标题最多50个字",
            "buyout_price.required"       => "请填写一口价",
            "buyout_price.numeric"         => "一口价填写错误",
            "buyout_price.min"             => "一口价必须大于2000",
            "market_price.min"             => "市场价必须大于2000",
            "market_price.required"       => "请填写市场价价",
            "market_price.numeric"         => "市场价价填写错误",
            "detail.required"             => "请填写详情",
            "files.array"                 => "图片或视频格式不正确",
            "files.*.type.required"         => "请上传图片或视频",
            "files.*.type.in.required"      => "文件类型错误",
            "files.*.url.required"          => "文件链接不能为空",
        ];
    }
}
