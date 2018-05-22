<?php

namespace App;


class Videos extends BaseModel
{
    protected $table = "videos";

    public function toArray()
    {
        return [
            "id"          => $this->id,
            "baike_id"    => $this->baike_id,
            "url"         => $this->url,
            "title"       => $this->title,
            "click_count" => $this->click_count,
        ];
    }

    public function baike()
    {
        return $this->belongsTo(BaikeDetail::class , "baike_id","id");
    }
}
