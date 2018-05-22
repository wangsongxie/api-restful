<?php
/**
 * Created by PhpStorm.
 * User: DevKang
 * Date: 2017/4/26
 * Time: 19:31
 */


namespace App\Api\Controllers;


use App\Api\Traits\RestResponseTrait;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Nwidart\Modules\Collection;

class ApiController extends BaseController
{
    use RestResponseTrait;
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}