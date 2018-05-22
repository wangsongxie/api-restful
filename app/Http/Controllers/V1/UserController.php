<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/23
 * Time: 16:41
 */

namespace App\Http\Controllers\V1;


use App\Address;
use App\DogCollect;
use App\Http\Requests\AddressRequest;
use App\Http\Requests\IdRequest;
use App\Http\Requests\UpdateAddressRequest;
use App\Http\Requests\UpdateUserInfoRequest;
use App\Http\Requests\UserVerifyRequest;
use App\Http\Requests\VerifyRequest;
use App\Repsitories\SmsResitory;
use App\Repsitories\UserResitory;
use App\Services\UserService;
use App\Sms;
use App\UserIdentify;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class UserController extends BaseController
{
    protected $user;

    public function __construct(UserResitory $user)
    {
        $this->user = $user;
    }


    /**
     * @SWG\Definition(
     *   definition="user_info",
     *   type="object",
     *   @SWG\Property(property="user_info", type="object",
     *      @SWG\Property(property="headimgurl", type="string",description="头像"),
     *      @SWG\Property(property="nickname", type="string",description="昵称"),
     *      @SWG\Property(property="first_keep_pets_time", type="string",description="第一次养宠时间"),
     *      @SWG\Property(property="real_name", type="string",description="真实姓名"),
     *      @SWG\Property(property="sex", type="integer",description="性别：0-未知 1-男 2-女"),
     *      @SWG\Property(property="birthday", type="string",description="生日"),
     *  ),
     *  @SWG\Property(property="user", type="object",
     *      @SWG\Property(property="mobile", type="string",description="手机号"),
     *      @SWG\Property(property="name", type="string",description="登录账号名"),
     *      @SWG\Property(property="email", type="string",description="邮箱"),
     *  ),
     * )
     */


    /**
     * @SWG\Post(
     *      path="/user/verify",
     *      tags={"user"},
     *      operationId="user_verify",
     *      summary="卖家，用户|商家认证",
     *      description="<img src='https://ss1.baidu.com/6ONXsjip0QIZ8tyhnq/it/u=2614059592,2045137384&fm=173&s=D2183EC5601219C4702B146D03005058&w=219&h=146&img.JPEG'>",
     *      consumes={"application/json"},
     *      produces={"application/json"},
     *      security={{"api_key": {"scope"}}},
     *      @SWG\Parameter(
     *          in="body",
     *          name="body",
     *          description="data",
     *          required=true,
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="sell_type",
     *                  type="string",
     *                  description="认证类型，1个人，2商家",
     *              ),
     *               @SWG\Property(
     *                  property="mobile",
     *                  type="string",
     *                  description="手机号",
     *              ),
     *               @SWG\Property(
     *                  property="real_name",
     *                  type="string",
     *                  description="姓名",
     *              ),
     *               @SWG\Property(
     *                  property="id_card",
     *                  type="string",
     *                  description="身份证号",
     *              ),
     *               @SWG\Property(
     *                  property="id_card_image",
     *                  type="string",
     *                  description="身份证图片base64",
     *              ),@SWG\Property(
     *                  property="address",
     *                  type="string",
     *                  description="地址",
     *              ),@SWG\Property(
     *                  property="bank_name",
     *                  type="string",
     *                  description="银行",
     *              ),
     *               @SWG\Property(
     *                  property="bank_no",
     *                  type="string",
     *                  description="银行卡",
     *              ),@SWG\Property(
     *                  property="shop_name",
     *                  type="string",
     *                  description="店铺名称,商家认证必传，个人认证不传",
     *              ),@SWG\Property(
     *                  property="license_image_url",
     *                  type="string",
     *                  description="营业执照base64,商家认证必传，个人认证不传",
     *              ),@SWG\Property(
     *                  property="lon",
     *                  type="string",
     *                  description="经度，获取到了就传",
     *              ),@SWG\Property(
     *                  property="lat",
     *                  type="string",
     *                  description="维度，获取到了就传",
     *              ),@SWG\Property(
     *                  property="region_id",
     *                  type="string",
     *                  description="地区id",
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
     *              @SWG\Property(property="detail", type="object",
     *                  ref="#/definitions/muser_identify"
     *              )
     *          )
     *      ),
     * )
     */


    /**
     * @param UserVerifyRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function userVerify(VerifyRequest $request)
    {
        $type = $request->input("sell_type");
        switch ($type) {
            case UserIdentify::TYPE_PERSONAL : {
                $info = $request->only(['sell_type', 'mobile', 'real_name', 'id_card', 'id_card_image' ,'address', 'bank_name', 'bank_no', 'lon', 'lat', 'region_id']);
                $res  = UserService::verifyUser($info);
                break;
            }
            case UserIdentify::TYPE_SHOP : {
                $info = $request->only(['sell_type', 'mobile', 'real_name', 'id_card','id_card_image', 'address', 'bank_name', 'bank_no', 'shop_name', 'lon', 'lat', 'license_image_url' ,'region_id']);
                $res  = UserService::verifyUser($info);
                break;
            }
            default:
                $res = false;
        }
        if ($res) {
            return $this->responseSuccess('申请提交成功，请等待审核');
        } else {
            return $this->responseFailed('申请提交失败.');
        }
    }


    /**
     * @SWG\Get(
     *      path="/user/check_identify",
     *      tags={"user"},
     *      operationId="user.verify",
     *      summary="查看当前用户认证身份",
     *      description="",
     *      consumes={"application/json"},
     *      produces={"application/json"},
     *      security={{"api_key": {"scope"}}},
     *
     *      @SWG\Response(
     *          response=200,
     *          description="结果集",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(property="code", type="integer", description="状态码"),
     *              @SWG\Property(property="message", type="string", description="状态信息"),
     *              @SWG\Property(property="data", type="object",
     *                  @SWG\Property(property="verify_status", type="integer", description="0-未认证  1-正在审核 2-认证通过 3-认证失败 "),
     *                  @SWG\Property(property="verify_type", type="integer", description="认证类型 0-未知  1-个人 2-商家"),
     *
     *                  @SWG\Property(property="verify_message", type="string", description="认证提示信息： 例如：您的信息正在认证中！  您的信息认证不通过，请点击重新提交"),
     *              )
     *          )
     *      ),
     * )
     */

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function checkUserIdentify(Request $request)
    {
        $user = $request->user();
        $identify = $user->identify()->orderBy('id','desc')->first();
        if (!$identify) {
            return $this->responseData([
                'verify_status' => 0,
                'verify_type' => 0,
                'verify_message' => '请认证卖家身份',

            ]);
        }

        if ($identify->is_valid == 0) {
            return $this->responseData([
                'verify_status' => 1,
                'verify_type' => $identify->sell_type,
                'verify_message' => '您的信息正在审核认证中'
            ]);
        }

        if ($identify->is_valid == 1) {
            return $this->responseData([
                'verify_status' => 2,
                'verify_type' => $identify->sell_type,
                'verify_message' => '您的信息认证已经通过'
            ]);
        }

        if ($identify->is_valid == 2) {
            return $this->responseData([
                'verify_status' => 3,
                'verify_type' => $identify->sell_type,
                'verify_message' => '您的信息认证不通过请重新提交'
            ]);
        }

        return $this->responseData([
            'verify_status' => 0,
            'verify_type' => 0,
            'verify_message' => '请认证卖家身份'
        ]);
    }



    /**
     * @SWG\Post(
     *      path="/user/info/update",
     *      tags={"user"},
     *      operationId="user.update",
     *      summary="更新个人信息",
     *      description="更新个人信息",
     *      consumes={"application/json"},
     *      produces={"application/json"},
     *      security={{"api_key": {"scope"}}},
     *      @SWG\Parameter(
     *          in="body",
     *          name="body",
     *          description="data",
     *          required=true,
     *          @SWG\Schema(
     *              type="object",
     *              ref="#/definitions/user_info"
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
     *                  ref="#/definitions/user_info"
     *              )
     *          )
     *      ),
     * )
     */
    public function updateUserinfo(UpdateUserInfoRequest $request)
    {
        $user_info = $request->get('user_info');
        $userData = $request->get('user');
        $user = $request->user();
        if ($user->userInfo()->update($user_info) && $user->update(['name' => $userData['name']])) {
            $user_info = $user->userInfo()
                ->select([
                    'headimgurl',
                    'nickname',
                    'first_keep_pets_time',
                    'real_name',
                    'sex',
                    'birthday',
                ])
                ->first()->toArray();
            $user = $user->makeHidden([
                'id',
            ])->toArray();

            return $this->responseData(compact('user_info', 'user'));
        } else {
            return $this->responseFailed("更新失败");
        }
    }


    /**
     * @SWG\Post(
     *      path="/user/update_mobile",
     *      tags={"user"},
     *      operationId="user.update_mobile",
     *      summary="更新手机号",
     *      description="更新手机号",
     *      consumes={"application/json"},
     *      produces={"application/json"},
     *      security={{"api_key": {"scope"}}},
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
     *                  description="新手机号",
     *              ),
     *               @SWG\Property(
     *                  property="code",
     *                  type="string",
     *                  description="短信验证码, 获取的时候type传change_mobile",
     *              )
     *          )
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="验证错误信息",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(property="code", type="string",description="1成功，0失败"),
     *              @SWG\Property(property="data", type="string",description="数据"),
     *              @SWG\Property(property="message", type="string",description="提示信息"),
     *              )
     *          )
     *      ),
     * )
     */
    public function updateMobile(UpdateUserInfoRequest $request , SmsResitory $sms)
    {
        $mobile = $request->input('mobile',null);
        $code = $request->input('code',null);
        if(!$sms->validate($mobile , $code , Sms::CHANGE_MOBILE))
        {
            return $this->failed("验证码错误");
        }
        if($mobile == Auth::user()->mobile)
        {
            return $this->failed("不能和原手机相同");
        }
        if($this->user->update(['mobile' => $mobile] ,  Auth::id()))
        {
            Auth::user()->mobile = $mobile ;
            return $this->success(['user' => Auth::user()] , 0 , '更新成功');
        }
        else{
            return $this->failed("更新失败");
        }
    }


    /**
     * @SWG\Post(
     *      path="/user/add_address",
     *      tags={"user"},
     *      operationId="user.add_address",
     *      summary="新增地址",
     *      description="",
     *      consumes={"application/json"},
     *      produces={"application/json"},
     *      security={{"api_key": {"scope"}}},
     *      @SWG\Parameter(
     *          in="body",
     *          name="body",
     *          description="data",
     *          required=true,
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="region_id",
     *                  type="string",
     *                  description="地域id",
     *              ),@SWG\Property(
     *                  property="is_default",
     *                  type="string",
     *                  enum="{0,1}",
     *                  description="是否默认",
     *              ),@SWG\Property(
     *                  property="address",
     *                  type="string",
     *                  description="详细地址",
     *              ),@SWG\Property(
     *                  property="username",
     *                  type="string",
     *                  description="姓名",
     *              ),@SWG\Property(
     *                  property="mobile",
     *                  type="string",
     *                  description="手机号",
     *              ),
     *          )
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="验证错误信息",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(property="code", type="string",description="状态信息"),
     *              @SWG\Property(property="message", type="string",description="提示信息"),
     *              )
     *          )
     *      ),
     * )
     */
    public function addAddress(AddressRequest $request)
    {
        if ($request->input('is_default') == 1) {
            Address::where(['user_id' => Auth::id()])->update([
                'is_default' => 0
            ]);
        }
        $addr = Address::create(array_merge($request->all() , ['user_id' => Auth::id()]));
        if($request->input("is_default") == 1)
        {
            Address::where('user_id', Auth::id())->where('id','<>' , $addr->id)->update(['is_default' => 0]);
        }
        return $this->responseSuccess('添加成功');
    }


    /**
     * @SWG\Post(
     *      path="/user/update_address",
     *      tags={"user"},
     *      operationId="user.add_address",
     *      summary="更新地址",
     *      description="",
     *      consumes={"application/json"},
     *      produces={"application/json"},
     *      security={{"api_key": {"scope"}}},
     *      @SWG\Parameter(
     *          in="body",
     *          name="body",
     *          description="data",
     *          required=true,
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="id",
     *                  type="integer",
     *                  description="地址id",
     *              ),
     *              @SWG\Property(
     *                  property="region_id",
     *                  type="string",
     *                  description="地域id",
     *              ),@SWG\Property(
     *                  property="is_default",
     *                  type="string",
     *                  enum="{0,1}",
     *                  description="是否默认",
     *              ),@SWG\Property(
     *                  property="address",
     *                  type="string",
     *                  description="详细地址",
     *              ),@SWG\Property(
     *                  property="username",
     *                  type="string",
     *                  description="姓名",
     *              ),@SWG\Property(
     *                  property="mobile",
     *                  type="string",
     *                  description="手机号",
     *              ),
     *          )
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="验证错误信息",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(property="code", type="string",description="状态信息"),
     *              @SWG\Property(property="message", type="string",description="提示信息"),
     *              )
     *          )
     *      ),
     * )
     */
    public function updateAddress(UpdateAddressRequest $request)
    {
        $id = $request->input("id");
        $user = $request->user();
        $addr = Address::find($id);
        if ($addr->user_id != $user->id) {
            return $this->responseFailed('无权更新');
        }
        $addr->fill($request->only(['region_id', 'is_default', 'address', 'username', 'mobile']));
        $addr->save();
        if($request->input("is_default") == 1)
        {
            Address::where('user_id', Auth::id())->where('id','<>' , $addr->id)->update(['is_default' => 0]);
        }
        return $this->responseSuccess('更新成功');
    }

    /**
     * @SWG\Get(
     *      path="/user/address",
     *      tags={"user"},
     *      operationId="user.address",
     *      summary="地址列表",
     *      description="",
     *      consumes={"application/json"},
     *      produces={"application/json"},
     *      security={{"api_key": {"scope"}}},
     *      @SWG\Response(
     *          response=200,
     *          description="验证错误信息",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(property="code", type="string",description="1成功，0失败"),
     *              @SWG\Property(property="message", type="string",description="返回提示"),
     *              @SWG\Property(property="data", type="object",
     *                  @SWG\Property(property="list", type="array",
     *                      @SWG\Items(type="object",
     *                          @SWG\Property(property="id", type="integer",description="地区id"),
     *                          @SWG\Property(property="user_id", type="integer",description="用户id"),
     *                          @SWG\Property(property="region_id", type="integer",description="地区id"),
     *                          @SWG\Property(property="is_default", type="integer",description="是否默认 0-否 1-是"),
     *                          @SWG\Property(property="username", type="string",description="收件人姓名"),
     *                          @SWG\Property(property="mobile", type="string",description="收件人手机"),
     *                          @SWG\Property(property="address", type="string",description="收件人地址"),
     *                          @SWG\Property(property="address_detail", type="string",description="详细地址（包含地区暂时同收件人地址）"),
     *                          @SWG\Property(property="region_info", type="object",
     *                              @SWG\Property(property="province", type="object",
     *                                  @SWG\Property(property="region_id", type="integer",description="地区id"),
     *                                  @SWG\Property(property="parent_region_id", type="integer",description="上级地区id"),
     *                                  @SWG\Property(property="name", type="string",description="名称"),
     *                                  @SWG\Property(property="pinyin", type="string",description="拼音"),
     *                              ),
     *                             @SWG\Property(property="city", type="object",
     *                                  @SWG\Property(property="region_id", type="integer",description="地区id"),
     *                                  @SWG\Property(property="parent_region_id", type="integer",description="上级地区id"),
     *                                  @SWG\Property(property="name", type="string",description="名称"),
     *                                  @SWG\Property(property="pinyin", type="string",description="拼音"),
     *                              ),
     *                          ),
     *                      ),
     *                  ),
     *              ),
     *          )
     *      ),
     * )
     */
    public function addressList()
    {
        $data = Auth::user()->address()->get();
        return $this->responseData(['list' => $data->toArray()]);
    }

    /**
     * @SWG\Post(
     *      path="/user/del_address",
     *      tags={"user"},
     *      operationId="user.del_address",
     *      summary="删除地址",
     *      description="",
     *      consumes={"application/json"},
     *      produces={"application/json"},
     *      security={{"api_key": {"scope"}}},
     *      @SWG\Parameter(
     *          in="body",
     *          name="body",
     *          description="地址id",
     *          required=true,
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="id",
     *                  type="string",
     *                  description="地址编号",
     *              )
     *          )
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="验证错误信息",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(property="code", type="string",description="1成功，0失败"),
     *              @SWG\Property(property="data", type="string",description="数据"),
     *              @SWG\Property(property="list", type="object",ref="#/definitions/mAddress"),
     *              )
     *          )
     *      ),
     * )
     */
    public function delAddress(IdRequest $request)
    {
        $id = $request->input("id");
        $address = Auth::user()->address()->where('id', $id)->first();
        if($address)
        {
            $res = $address->delete();
            if($res)
            {
                return $this->success([],0,'删除成功');
            }
        }
        return $this->failed("删除失败");
    }


    /**
     * @SWG\Get(
     *      path="/user/collect",
     *      tags={"user"},
     *      operationId="user.collect",
     *      summary="用户狗狗收藏列表",
     *      description="<img src='https://attachments.tower.im/tower/4f1df55b79154afd916a05d47f2fd84c?filename=%E6%88%91%E7%9A%84%E6%94%B6%E8%97%8F.png'>",
     *      consumes={"application/json"},
     *      produces={"application/json"},
     *      security={{"api_key": {"scope"}}},
     *     @SWG\Parameter(
     *          in="query",
     *          name="page",
     *          description="页码",
     *          required=false,
     *          type="string",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="page",
     *                  type="string",
     *                  description="页码",
     *              )
     *          )
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(property="code", type="string",description=""),
     *              @SWG\Property(property="data", type="string",description="数据"),
     *              @SWG\Property(property="list", type="object",ref="#/definitions/mdogCollect"),
     *              )
     *          )
     *      ),
     * )
     */
    public function collect()
    {
        $list = DogCollect::where('user_id',Auth::id())->paginate(10);
        return $this->success(['list' => $list]) ;
    }



    /**
     * @SWG\Get(
     *      path="/user/info",
     *      tags={"user"},
     *      operationId="user.collect",
     *      summary="获取当前用户个人信息",
     *      description="<img src='https://attachments.tower.im/tower/79a6b5d6238e42789230013f2cd0f9ff?filename=%E4%B8%AA%E4%BA%BA%E4%BF%A1%E6%81%AF.png'>",
     *      consumes={"application/json"},
     *      produces={"application/json"},
     *      security={{"api_key": {"scope"}}},
     *      @SWG\Response(
     *          response=200,
     *          description="",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(property="code", type="string",description=""),
     *              @SWG\Property(property="message", type="string",description="提示信息"),
     *              @SWG\Property(property="data", type="object",
     *                  ref="#/definitions/user_info"
     *              ),
     *          )
     *      ),
     * )
     */

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUserInfo(Request $request)
    {
        $user = $request->user();

        $user_info = $user->userInfo()
            ->select([
                'headimgurl',
                'nickname',
                'first_keep_pets_time',
                'real_name',
                'sex',
                'birthday',
                ])
            ->first()->toArray();
        $user = $user->makeHidden([
            'id',
        ])->toArray();
        return $this->responseData(compact('user_info', 'user'));
    }
}
