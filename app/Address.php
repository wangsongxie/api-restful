<?php

namespace App;


class Address extends BaseModel
{

    protected $table = 'address';

    protected $appends = [
        'address_detail',
        'region_info',
    ];
    public function regionInfo()
    {
        return $this->belongsTo(Region::class,'region_id', 'region_id');
    }

    public function getAddressDetailAttribute()
    {
        return $this->address;
    }

    public function getRegionInfoAttribute()
    {
        $region = Region::where([
            'region_id' => $this->region_id
        ])->first();
        $province = (object)null;
        $city = (object)null;

        if ($region) {
            if ($region->parent_region_id) {
                $province = Region::where([
                    'region_id' => $region->parent_region_id
                ])->first();
                $city = $region;
            } else {
                $province = $region;
            }
        }
        return [
            'province' => $province,
            'city' => $city
        ];
    }
}
