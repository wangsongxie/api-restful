<?php
/**
 * Created by PhpStorm.
 * User: DevKang
 * Date: 2017/5/2
 * Time: 21:55
 */

namespace App\Transformers ;


use App\Api\Transformer\BaseTransformer;

class CommentsTransformer extends BaseTransformer
{
    public static function transform($item)
    {
        return $item;
    }



}