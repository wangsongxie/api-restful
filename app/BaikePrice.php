<?php

namespace App;

class BaikePrice extends BaseModel
{
    protected $table = "baike_price";


    public function toArray()
    {
        return [
            'id'         => $this->id,
            'low'        => $this->low,
            "medium"     => $this->medium,
            'high'       => $this->high,
            'baike_id'   => $this->baike_id,
            "month"      => preg_replace('/^\d{2}(\d{2}\-\d{2})\-\d{2}$/','$1',$this->month),
        ];
    }
    
    public function baike()
    {
        return $this->belongsTo(BaikeDetail::class , "baike_id","id");
    }
}
