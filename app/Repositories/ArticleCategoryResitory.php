<?php
namespace App\Repsitories ;

use App\Article;
use App\ArticleCategory;
use App\DogsCategory;
use Bosnadev\Repositories\Eloquent\Repository;

class ArticleCategoryResitory extends Repository
{
    public function model()
    {
        return ArticleCategory::class ;
    }

    public function getIndex()
    {
        return $this->model->select("name","thumb","id","pid")->offset(0)->limit(8)->get();
    }

    // 喂养  id = 2
    public function getSecondCategory($pid)
    {
        return $this->model->where('pid',$pid)->get();
    }

    // 喂养文章列表
}
