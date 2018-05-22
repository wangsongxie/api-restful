<?php

namespace App\Repsitories;

use App\Article;
use App\ArticleCollect;
use App\ArticleLike;
use Bosnadev\Repositories\Eloquent\Repository;
use Illuminate\Support\Facades\Auth;

class ArticleResitory extends Repository
{
    public function model()
    {
        return Article::class;
    }

    public function getArticleList($cate_id, $keywords = null)
    {
        $model = $this->model;
        if ($cate_id) {
            $model = $model->where('cate_id', $cate_id);
        }
        if (!is_null($keywords)) {
            $model = $model->where(function ($query) use ($keywords) {
                $query->orWhere("title", "like", "%{$keywords}%");
            });
        }

        return $model->with(['articleInfo' => function ($query) {
            $query->select(['article_id', 'desc']);
        }])->select("id", "cate_id", "title", "thumb", "is_hot", "created_at")->paginate(10);
    }

    // 点赞
    public function likeArticle($id)
    {
        $uid = Auth::id();
        if ($exist = ArticleLike::where("user_id", $uid)->where("article_id", $id)->first()) {
            $exist->delete();
            return false;
        } else {
            return ArticleLike::insert([
                "user_id" => $uid,
                "article_id" => $id,
            ]);
        }
    }

    // 收藏
    public function collectArticle($id)
    {
        $uid = Auth::id();
        if ($exist = ArticleCollect::where("user_id", $uid)->where("article_id", $id)->first()) {
            $exist->delete();
            return false;
        } else {
            return ArticleCollect::insert([
                "user_id" => $uid,
                "article_id" => $id,
            ]);
        }
    }
}
