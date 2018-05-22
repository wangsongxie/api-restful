<?php

namespace App;


use App\Scopes\OrderByScope;

class Region extends BaseModel
{
    protected $table = "regions";
    public $timestamps = false;
    protected $hidden = ['id'];


    public static function boot()
    {
        parent::boot();

        static::addGlobalScope(new OrderByScope('id', 'asc'));
    }

    public static function getRegionInfoByRegionId($regionId)
    {
        $region = self::where([
            'region_id' => $regionId
        ])->first();
        if ($region && $region->parent_id != 0) {
            $region->parent = self::getRegionInfoByRegionId($region->parent_id);

        }
        return $region;
    }

}
