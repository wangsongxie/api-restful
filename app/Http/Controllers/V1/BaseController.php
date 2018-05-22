<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/22
 * Time: 12:57
 */
namespace App\Http\Controllers\V1;


use App\Api\Controllers\ApiController;
use App\Api\Helpers\Api\ApiResponse;
use App\Http\Controllers\Controller ;
use App\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class BaseController extends ApiController
{
    use ApiResponse , AuthenticatesUsers ;



    /**
     * @SWG\Swagger(
     *   host="",
     *   basePath="/api/v1",
     *   @SWG\Info(
     *     title="app",
     *     version="1.0.0"
     *   ),
     * @SWG\SecurityScheme(
     *   securityDefinition="api_key",
     *   type="apiKey",
     *   in="header",
     *   description = "认证token  Bearer+空格+token",
     *   name="Authorization"
     * ),
     * )
     */
    public function __construct()
    {
//        $this->middleware("auth:api")->only(['logout']);
    }

    public function validation($request, $rule ,$replace)
    {
        $this->validate($request , $rule , [] , $replace);
    }
}
