<?php

namespace App;

use Illuminate\Support\Facades\Auth;

class Article extends BaseModel
{
    protected $table = 'articles';

    protected $appends = [
//        'desc'
    ];
//    public function toArray()
//    {
//        return [
//            "id" => $this->id ,
//            "cate_id" => $this->cate_id ,
//            "title" => $this->title ,
//            "thumb" => $this->thumb ,
//            "from" => $this->from ,
//            "content" => $this->content ,
//            "created_at" => $this->created_at->toDateString() ,
//            'is_hot' => $this->is_hot ,
//            "desc" => $this->desc ,
//            "is_like" => $this->isLike(),
//            "is_collect" => $this->isCollect(),
//        ];
//    }



    public function categories()
    {
        return $this->belongsTo(ArticleCategory::class , "cate_id","id");
    }

    public function isLike()
    {
        if(Auth::guest())
        {
            return false ;
        }
        $user = Auth::user();
        return ArticleLike::where("user_id",$user->id)->where("article_id",$this->id)->exists();
    }

    public function isCollect()
    {
        if(Auth::guest())
        {
            return false ;
        }
        $user = Auth::user();
        return ArticleCollect::where("user_id",$user->id)->where("article_id",$this->id)->exists();
    }

    public function articleInfo()
    {
        return $this->hasOne(ArticleInfo::class, 'article_id', 'id')->select(['desc', 'article_id']);
    }
}
