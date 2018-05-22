<?php
/**
 * Created by PhpStorm.
 * User: DevKang
 * Date: 2017/5/7
 * Time: 03:35
 */

namespace App\Api\Transformer;


abstract class BaseTransformer
{

    public static function transforms($collection)
    {

        if (!$collection) {
            return [];
        }
        if (isset($collection['data'])) {
            $collection['lists'] = $collection['data'];
            unset($collection['data']);

            if ($collection['lists']) {
                $collection['lists'] = array_map(function ($data) {
                    return static::transform($data);
                }, $collection['lists']);
            }


             return $collection;
        }


        return array_map(function ($data) {
            return static::transform($data);
        }, $collection);
    }
}