<?php

namespace App;

class ArticleCategory extends BaseModel
{
    public function toArray()
    {
        return [
            'id' => $this->id ,
            'thumb' => $this->thumb,
            'name' => $this->name ,
            'pid' => $this->pid ,
            'dogs' => $this->dogsCategory()->get(),
        ];
    }

    public function articles()
    {
        return $this->hasMany(Article::class,"cate_id","id");
    }

    public function dogsCategory()
    {
        return $this->hasOne(DogsCategory::class , "article_cate_id","id");
    }
}
