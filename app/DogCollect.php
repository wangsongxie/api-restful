<?php

namespace App;


class DogCollect extends BaseModel
{
    protected $table = "dog_collect";

    public function dog()
    {
        return $this->belongsTo(Dog::class,'dog_id','id');
    }

    public function toArray()
    {
        return [
            'id' => $this->id ,
            'dog' => $this->dog()->first(),
            'user_id' => $this->user_id ,
            'created_at' => $this->created_at->toDateString(),
        ];
    }
}
