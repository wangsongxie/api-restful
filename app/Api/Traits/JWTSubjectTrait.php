<?php
namespace App\Api\Traits;
/**
 * Created by PhpStorm.
 * User: DevKang
 * Date: 2017/7/21
 * Time: 18:30
 */
Trait JWTSubjectTrait
{
    public function getJWTIdentifier()
    {
        $key = $this->getKey();
        return $key; // Eloquent Model method
    }

    public function getJWTCustomClaims()
    {
        return [
        ];
    }
}