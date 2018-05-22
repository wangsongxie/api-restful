<?php
/**
 * Created by PhpStorm.
 * User: DevKang
 * Date: 2017/7/15
 * Time: 19:16
 */

namespace App\Scopes;


use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class OrderByScope implements Scope
{
    private $primaryKey;

    private $sort;

    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return void
     */
    public function __construct($primaryKey = 'id', $sort = 'desc')
    {
        $this->primaryKey = $primaryKey;
        $this->sort = $sort;
    }

    public function apply(Builder $builder, Model $model)
    {
        return $builder->orderBy($this->primaryKey, $this->sort);
    }
}