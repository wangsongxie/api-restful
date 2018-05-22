<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/22
 * Time: 16:02
 */
namespace App ;
use App\Scopes\OrderByScope;
use \Illuminate\Database\Eloquent\Model as M ;
class BaseModel extends M
{
    protected $guarded = ['id'] ;
    protected $hidden = ['password', 'created_at', 'updated_at', 'deleted_at'];


    public static function boot()
    {
        parent::boot();

        static::addGlobalScope(new OrderByScope());
    }
}
