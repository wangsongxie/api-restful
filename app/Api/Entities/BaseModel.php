<?php
/**
 * Created by PhpStorm.
 * User: DevKang
 * Date: 2017/5/6
 * Time: 23:35
 */

namespace App\Api\Entities;


use App\Scopes\OrderByScope;
use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    // softDelete
    protected $dates = ['deleted_at'];

    protected $guarded = ['id'];

    protected $hidden = ['password', 'created_at', 'updated_at', 'deleted_at'];

    public static function boot()
    {
        parent::boot();

        static::addGlobalScope(new OrderByScope());
    }

    public function getAttribute($key)
    {
        return parent::getAttribute(snake_case($key));
    }

    public function setAttribute($key, $value)
    {
        return parent::setAttribute(snake_case($key), $value);
    }
    /**
     * create or update record
     *
     * @param $data
     * @return bool|static
     */
    public static function createOrUpdate($data)
    {
        $model = new static();

        if (!empty($data[$model->primaryKey])) {
            $model = static::where([$model->primaryKey => $data[$model->primaryKey]])->first();
            if (!$model) {
                return false;
            }
        }
        $model->fill($data);
        $model->save();
        return $model;

    }

    /**
     * softDelete
     *
     * @param $data
     * @return mixed
     */
    public static function softDelete($data)
    {
        // 考虑代码兼容性问题。
        if (isset($data['ids'])) {
            $data['id'] = $data['ids'];
            unset($data['ids']);
        }
        $model = new static();
        foreach ($data as $key => $val) {
            $model = $model->whereIn($key, $val);
        }

        return $model->delete();

    }


    /**
     * 更新数据
     *
     * @param $data
     * @return bool
     */
    public function updateData($data)
    {
        $this->fill($data);

        $result = $this->save();

        return $result;
    }

    /**
     *
     */
    public static function createOrDelete($where)
    {
        $model = static::where($where)->first();

        if ($model) {
            $model->delete();
            return 2;
        }
        if (!$model) {
            if (static::create($where)) {
                return 1;
            }

        }

        return false;
    }
}