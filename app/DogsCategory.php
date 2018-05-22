<?php

namespace App;


class DogsCategory extends BaseModel
{

    protected $table = "dog_categories";

    protected $hidden = ['pid', 'created_at', 'updated_at', 'deleted_at'];

    public function dog()
    {
        return $this->hasMany(Dog::class,"cate_id","id");
    }

    public function articleCategories()
    {
        return $this->belongsTo(ArticleCategory::class,"article_cate_id","id");
    }
}
