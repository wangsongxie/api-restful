<?php

namespace App;

class ArticleComment extends BaseModel
{
    protected $table = 'article_comments';


    public static function createComment($data)
    {
        return self::create($data);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id')->select(['id']);
    }
}
