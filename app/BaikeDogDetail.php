<?php

namespace App;

class BaikeDogDetail extends BaseModel
{
    protected $table = "baike_dog_detail";

    public function baike()
    {
        return $this->belongsTo(BaikeDetail::class , "baike_id","id");
    }
}
