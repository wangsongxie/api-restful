<?php

namespace App;


class DogFile extends BaseModel
{
    const PICTURE = 1 ;
    const VIDEO = 2 ;

    protected $table = "dogs_files";

    public function dogs()
    {
        return $this->belongsTo(Dog::class,"dog_id","id");
    }

    public function toArray()
    {
        return [
            'url' => $this->url ,
            'type' => $this->type ,
            'dog_id' => $this->dog_id,
        ];
    }
}
