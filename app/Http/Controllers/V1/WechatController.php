<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/23
 * Time: 16:41
 */

namespace App\Http\Controllers\V1;


use App\Http\Requests\WechatLoginRequest;
use App\Services\OpenWechatService;
use App\User;
use App\UserInfo;


class WechatController extends BaseController
{

    /**
     * @SWG\Post(
     *      path="/wechat/login",
     *      tags={"guest"},
     *      operationId="wechat.login",
     *      summary="微信登录",
     *      description="",
     *      consumes={"application/json"},
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          in="body",
     *          name="body",
     *          description="data",
     *          required=true,
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="code",
     *                  type="string",
     *                  description="微信登录code",
     *                  default=""
     *              ),

     *          )
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="结果集",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(property="code", type="integer", description="状态码"),
     *              @SWG\Property(property="message", type="string", description="状态信息"),
     *              @SWG\Property(property="data", type="object",
     *                  @SWG\Property(property="is_bind_user", type="integer", description="是否绑定用户信息 0-绑定 1-未绑定" ,),
     *                  @SWG\Property(property="access_token", type="string", description="access_token，跟手机登录token一致，如果未绑定用户，此字段不返"),
     *                  @SWG\Property(property="code", type="string", description="微信登录授权以后拿到的code，用户下次用户绑定手机使用。"),
     *              )
     *          )
     *      ),
     * )
     */
    public function WechatLogin(WechatLoginRequest $request)
    {
        $code = $request->input('code');
        $result = OpenWechatService::getAccessTokenByCode($code);
        cache([$code => $result], now()->addSeconds(7200));
        $wechatInfo = json_decode($result, true);
        if (!empty($wechatInfo['errcode'])) {
            return $this->responseFailed($wechatInfo['errmsg']);
        }
        $userInfo = UserInfo::where([
            'wx_openid' => $wechatInfo['openid']
        ])->first();
        if ($userInfo) {
            $user = User::find($userInfo->user_id);
            $access_token = \JWTAuth::fromUser($user);

            return $this->responseData([
                'user' => $user,
                'is_user_bind' => 1,
                'access_token' => $access_token,
            ]);
        }

        return $this->responseData([
            'is_user_bind' => 0,
            'code' => $code,
        ]);
    }
}
