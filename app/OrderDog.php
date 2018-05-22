<?php

namespace App;

class OrderDog extends BaseModel
{
    protected $table = "order_dogs";

    protected $dates = [
        'deleted_at',
    ];

    public function toArray()
    {
        return [
            'id' => $this->id ,
            'cate_id' => $this->cate_id ,
            'category' => $this->category()->value('name') ,
            'birthday' => $this->birthday,
            'vaccine' => $this->vaccine,
            'sex' => $this->sex,
            'sterilization' => $this->sterilization,
            'grade' => $this->grade,
            'body_size' => $this->body_size,
            'insect' => $this->insect,
            'is_presell' => $this->is_presell,
            'health_ensure_days' => $this->health_ensure_days,
            'title' => $this->title,
            'buyout_price' => $this->buyout_price,
            'presell_price' => $this->presell_price,
            "thumb" => $this->thumb,
            "order_id" => $this->order_id ,
            "dog_id" => $this->dog_id ,
        ];
    }

    public function category()
    {
        return $this->belongsTo(DogsCategory::class,"cate_id","id");
    }

    public function order()
    {
        return $this->belongsTo(Orders::class,"order_id","id");
    }
}
