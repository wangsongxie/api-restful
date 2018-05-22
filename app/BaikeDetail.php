<?php

namespace App;

class BaikeDetail extends BaseModel
{
    protected $table = "baike_detail";

    public function toArray()
    {
        return [
            "id"            => $this->id,
            "dogcate_id"    => $this->dogcate_id,
            "banner_imgurl" => $this->banner_imgurl,
            "desc"          => $this->desc,
            "market_price"  => $this->market_price,
            "history"       => $this->history,
            "feature"       => $this->feature,
            "dog_detail"    => $this->dogDetail()->first(),
        ];
    }

    public function dogDetail()
    {
        return $this->hasOne(BaikeDogDetail::class, "baike_id", "id");
    }

    public function price()
    {
        return $this->hasMany(BaikePrice::class, "baike_id", "id");
    }

    public function videos()
    {
        return $this->hasMany(Videos::class,"baike_id","id");
    }
}
