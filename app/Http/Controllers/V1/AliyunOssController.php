<?php

namespace App\Http\Controllers\V1;

use App\Api\Controllers\ApiController;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterMessageCodeRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\UpdateUserInfoRequest;
use App\Http\Requests\UserSubscribeRequest;
use App\Services\YunPianService;
use App\User;
use App\UserSubscribeRelation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Sts\AssumeRoleRequest;
use Sts\Core\DefaultAcsClient;
use Sts\Core\Profile\DefaultProfile;
use Tymon\JWTAuth\Exceptions\JWTException;

class AliyunOssController extends ApiController
{

    /**
     * @SWG\Get(path="/aliyun/getOssSts",
     *   tags={"aliyun"},
     *   summary="获取阿里云OSS STS",
     *   security={{"api_key": {"scope"}}},
     *   produces={"application/json"},
     *   @SWG\Response(
     *     response=200,
     *     description="请求成功",
     *   @SWG\Schema(
     *     type="object",
     *     @SWG\Property(property="code", type="integer", description="状态码"),
     *     @SWG\Property(property="message", type="string", description="状态信息"),
     *     @SWG\Property(property="data", type="object",
     *           @SWG\Property(property="AccessKeySecret", type="string", description="表示Android/iOS应用初始化OSSClient获取AccessKeySecret"),
     *           @SWG\Property(property="AccessKeyId", type="string", description="表示Android/iOS应用初始化OSSClient获取的 AccessKeyId"),
     *           @SWG\Property(property="Expiration", type="string", description="表示该Token失效的时间。主要在Android SDK会自动判断是否失效，自动获取Token。"),
     *           @SWG\Property(property="SecurityToken", type="string", description="表示Android/iOS应用初始化的Token"),
     *     ),
     *     )
     *   )
     *   )
     * )
     */
    public function getSts()
    {
        $credentials = Cache::get('aliyun_oss_sts_credentials');
//        $credentials = false;/**/
        if (!$credentials) {
            // 你需要操作的资源所在的region，STS服务目前只有杭州节点可以签发Token，签发出的Token在所有Region都可用
            // 只允许子用户使用角色
            $iClientProfile = DefaultProfile::getProfile("cn-beijing", config('aliyun_sts.key'), config('aliyun_sts.secret'));
            $client = new DefaultAcsClient($iClientProfile);

// 角色资源描述符，在RAM的控制台的资源详情页上可以获取
            $roleArn = config('aliyun_sts.role_arn');


            // 在扮演角色(AssumeRole)时，可以附加一个授权策略，进一步限制角色的权限；
            // 详情请参考《RAM使用指南》
            // 此授权策略表示读取所有OSS的只读权限
            $policy = json_encode(config('aliyun_sts.policy'));
            $expire_time = config('aliyun_sts.expire_time');
            $request = new AssumeRoleRequest();
            // RoleSessionName即临时身份的会话名称，用于区分不同的临时身份
            // 您可以使用您的客户的ID作为会话名称
            $request->setRoleSessionName("client_name");
            $request->setRoleArn($roleArn);
            $request->setPolicy($policy);
            $request->setDurationSeconds($expire_time);
            $response = $client->doAction($request);
            $result = $response->getBody();
            $credentials = json_encode(json_decode($result)->Credentials);
            Cache::put('aliyun_oss_sts_credentials', $credentials, $expire_time / 60);
        }



        return $this->responseData(json_decode($credentials, true));
    }
}
