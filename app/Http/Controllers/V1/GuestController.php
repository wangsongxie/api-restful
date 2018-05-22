<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/22
 * Time: 14:25
 */

namespace App\Http\Controllers\V1;


use App\Http\Requests\BindMobileRequest;
use App\Http\Requests\UserRegisterRequest;
use App\Region;
use App\Repsitories\SmsResitory;
use App\Repsitories\UserResitory;
use App\Services\OpenWechatService;
use App\Sms;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;

class GuestController extends BaseController
{
    protected $sms;

    protected $user;

    public function __construct(SmsResitory $smsResitory, UserResitory $userResitory)
    {
        parent::__construct();
        $this->sms = $smsResitory;
        $this->user = $userResitory;
    }

    public function username()
    {
        return 'mobile';
    }

    /**
     * @SWG\Post(
     *      path="/sms",
     *      tags={"guest"},
     *      operationId="sms",
     *      summary="获取短信验证码",
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
     *                  property="mobile",
     *                  type="string",
     *                  description="手机号",
     *              ),@SWG\Property(
     *                  property="type",
     *                  type="string",
     *                  description="类型:register|login|change_mobile|bind",
     *              )
     *          )
     *      ),
     *     @SWG\Response(
     *          response=200,
     *          description="结果集",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(property="code", type="integer", description="状态码"),
     *              @SWG\Property(property="message", type="string", description="状态信息"),
     *          )
     *      ),
     * )
     */
    public function sendsms(Request $request)
    {
        $this->validate($request, [
            'mobile' => 'required|mobile',
            'type' => 'required|in:register,login,change_mobile,bind'
        ], [
            'mobile.required' => trans('app.mobile'),
            'type.required' => '类型必须',
            'type.in' => '短信类型错误',
        ]);
        $mobile = $request->get("mobile");
        $type = $request->get("type");
        if ($this->sms->tooManyAttempts($mobile)) {
            return $this->failed("请求频繁");
        }
        $code = $this->sms->sendSms($mobile, $type);
        if ($code == false) {
            return $this->failed("发送失败");
        }
        if (app()->isLocal()) {
            return $this->success(['code' => $code]);
        } else {
            return $this->success([], 0, '发送成功');
        }
    }

    /**
     * @SWG\Post(
     *      path="/register",
     *      tags={"guest"},
     *      operationId="register",
     *      summary="用户注册",
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
     *                  property="mobile",
     *                  type="string",
     *                  description="手机号",
     *              ),
     *               @SWG\Property(
     *                  property="password",
     *                  type="string",
     *                  description="密码",
     *              ),
     *              @SWG\Property(
     *                  property="code",
     *                  type="string",
     *                  description="验证码",
     *              ),
     *          )
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="请求成功",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(property="code", type="integer", description="状态码"),
     *              @SWG\Property(property="message", type="string", description="状态信息"),
     *              @SWG\Property(property="data", type="object",
     *                  @SWG\Property(property="token", type="string", description="注册用户token"),
     *              ),
     *          ),
     *      ),
     * )
     */
    public function register(UserRegisterRequest $request)
    {
        $mobile = $request->get('mobile');
        $code = $request->get('code');
        $password = $request->get('password');

        // 验证验证码
        if ($this->sms->validate($mobile, $code, Sms::Register)) {
            $user = [
                'mobile' => $mobile,
                'password' => bcrypt($password),
            ];
            $user = $this->user->register($user);
            if ($user) {
                $user->userInfo()->create();
                $token = JWTAuth::fromUser($user);
                return $this->responseData(compact('token'));
            } else {
                return $this->responseFailed('注册失败');
            }
        } else {
            return $this->responseFailed("验证码错误");
        }
    }


    /**
     * @SWG\Post(
     *      path="/login",
     *      tags={"guest"},
     *      operationId="login",
     *      summary="用户登录",
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
     *                  property="type",
     *                  type="string",
     *                  description="登录方式qq|wx|sms|password",
     *                  default="qq"
     *              ),
     *               @SWG\Property(
     *                  property="mobile",
     *                  type="string",
     *                  description="手机号",
     *              ),
     *               @SWG\Property(
     *                  property="password",
     *                  type="string",
     *                  description="密码",
     *              ),
     *               @SWG\Property(
     *                  property="code",
     *                  type="string",
     *                  description="验证码",
     *              ),
     *               @SWG\Property(
     *                  property="qq_openid",
     *                  type="string",
     *                  description="qqopenid",
     *              ),@SWG\Property(
     *                  property="qq_name",
     *                  type="string",
     *                  description="qq登录返回失败的时候使用短信绑定该用户传qq信息",
     *              ),@SWG\Property(
     *                  property="qq_headimgurl",
     *                  type="string",
     *                  description="qq头像",
     *              ),
     *               @SWG\Property(
     *                  property="wx_openid",
     *                  type="string",
     *                  description="wxopenid",
     *              ),@SWG\Property(
     *                  property="wx_name",
     *                  type="string",
     *                  description="wx登录返回失败的时候使用短信绑定该用户传wx信息",
     *              ),@SWG\Property(
     *                  property="wx_headimgurl",
     *                  type="string",
     *                  description="微信头像",
     *              )
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
     *                  @SWG\Property(property="user", type="object", description="用户信息" ,ref="#/definitions/muser"),
     *                  @SWG\Property(property="access_token", type="string", description="token"),
     *              )
     *          )
     *      ),
     * )
     */
    public function login(Request $request)
    {
        $type = $request->get("type");
        $code = 0;
        $message = '';
        $user = null;
        $token = null;
        switch ($type) {
            case 'sms':
                $this->validation($request, [
                    'mobile' => 'required|mobile|exists:users',
                    'code' => 'required|regex:/\d{6}/',
                    'qq_openid' => 'sometimes|required',
                    'qq_headimgurl' => 'sometimes|required',
                    'qq_name' => 'sometimes|required',
                    'wx_openid' => 'sometimes|required',
                    'wx_headimgurl' => 'sometimes|required',
                    'wx_name' => 'sometimes|required',
                ], [
                    'mobile' => '手机号',
                    'code' => '验证码',
                ]);
                $mobile = $request->get("mobile");
                $code = $request->get("code");
                if (!$this->sms->validate($mobile, $code, Sms::Login)) {
                    $code = 1;
                    $message = "验证码错误";
                } else {
                    $user = $this->user->getByMobile($mobile);
                    if (!empty($request->input('qq_openid'))) {
                        $this->user->setQQinfo($user, $request);
                    }
                    if (!empty($request->input('wx_openid'))) {
                        $this->user->setWxinfo($user, $request);
                    }
                    $token = JWTAuth::fromUser($user);
                }
                break;
            case 'qq':
                $openid = $request->get('qq_openid');
                $user = $this->user->getByQQ($openid);
                if (!$user) {
                    $code = 1;
                    $message = '用户未绑定';
                } else {
                    $token = JWTAuth::fromUser($user);
                }
                break;
            case 'wx':
                $openid = $request->get('wx_openid');
                $user = $this->user->getByWx($openid);
                if (!$user) {
                    $code = 1;
                    $message = '用户未绑定';
                } else {
                    $token = JWTAuth::fromUser($user);
                }
                break;
            case 'password':
                $this->validation($request, [
                    'mobile' => 'required|mobile|exists:users',
                    'password' => 'between:6,32',
                ], [
                    'mobile' => '手机号',
                    'password' => '密码',
                ]);
                $credentials = $this->credentials($request);
                $token = JWTAuth::attempt($credentials);
                if (!$token) {
                    return $this->failed("账号或密码错误");
                }
                $user = Auth::user();
                break;
            default:
                return $this->failed("登录类型错误");
        }
        if ($code == 1) {
            return $this->failed($message);
        } else {
            return $this->success([
                'user' => $user,
                'access_token' => $token,
            ], 0, '登录成功');
        }
    }


    /**
     * @SWG\Get(
     *      path="/region",
     *      tags={"guest"},
     *      operationId="region",
     *      summary="省市区列表",
     *      description="省市区列表",
     *      consumes={"application/json"},
     *      produces={"application/json"},
     *     @SWG\Parameter(
     *          in="query",
     *          name="id",
     *          description="父级region_id. 顶级为0",
     *          required=false,
     *          type="string",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="id",
     *                  type="string",
     *                  description="父级region_id. 顶级为0",
     *              )
     *          )
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="结果集",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(property="code", type="integer", description="状态码"),
     *              @SWG\Property(property="message", type="string", description="状态信息"),
     *              @SWG\Property(property="detail", type="object",
     *                  ref="#/definitions/marticle"
     *              )
     *          )
     *      ),
     * )
     */
    public function region(Request $request)
    {
        $id = $request->input("id");
        if (!$id) {
            $data = Region::where("parent_region_id", '0')->get();
        } else {
            $data = Region::where('parent_region_id', $id)->get();
        }

        return $this->success($data);
    }


    /**
     * @SWG\Post(
     *      path="/bind/mobile",
     *      tags={"guest"},
     *      operationId="login",
     *      summary="绑定手机",
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
     *               @SWG\Property(
     *                  property="mobile",
     *                  type="string",
     *                  description="手机号",
     *              ),
     *               @SWG\Property(
     *                  property="mobile_code",
     *                  type="string",
     *                  description="验证码",
     *              ),
     *               @SWG\Property(
     *                  property="code",
     *                  type="string",
     *                  description="绑定code",
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
     *                  @SWG\Property(property="access_token", type="string", description="token"),
     *              )
     *          )
     *      ),
     * )
     */

    /**
     * @param BindMobileRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function bindMobile(BindMobileRequest $request)
    {
        $mobile = $request->input('mobile');
        $mobile_code = $request->input('mobile_code');
        $code = $request->input('code');
        if (!$this->sms->validate($mobile,$mobile_code,SMS::BIND)) {
            return $this->responseFailed('验证码错误');
        }
        $wxAccessInfo = cache($code);
        if (!$wxAccessInfo) {
            return $this->responseFailed('无法关联绑定信息');
        }
        if ($wxAccessInfo) {
            $wxUserInfo = OpenWechatService::getUserInfo(json_decode($wxAccessInfo, true));
            $wxUserInfo = json_decode($wxUserInfo, true);
            $userInfo = [
                'wx_openid' => $wxUserInfo['openid'],
                'nickname' => $wxUserInfo['nickname'],
                'headimgurl' => $wxUserInfo['headimgurl'],
                'wx_unionid' => $wxUserInfo['unionid'],
            ];
        }
        if ($user = $this->user->getByMobile($mobile)) {
            $this->user->setExistModel($user);
            $this->user->createOrUpdateUserInfo($userInfo);
            $access_token = JWTAuth::fromUser($user);

            return $this->responseData(compact('user','access_token'));
        }

        if (!$this->user->getByMobile($mobile)) {
            $user = $this->user->register([
                'mobile' => $mobile,
                'password' => 'wx_login',
            ]);
            if ($user) {
                $this->user->setExistModel($user);
                $this->user->createOrUpdateUserInfo($userInfo);
                $access_token = JWTAuth::fromUser($user);

                return $this->responseData(compact('user','access_token'));
            }

        }
        return $this->responseFailed();
    }
}
