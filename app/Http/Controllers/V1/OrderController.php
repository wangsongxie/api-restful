<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/12/1
 * Time: 10:12
 */

namespace App\Http\Controllers\V1;

use App\Transformers\CollectionsTransformer;
use EasyWeChat\Kernel\Support;
use App\Http\Requests\IdRequest;
use App\Http\Requests\OrderNoRequest;
use App\Http\Requests\OrderRequest;
use App\Http\Requests\PayRequest;
use App\Orders;
use App\Repsitories\OrderResitory;
use App\Services\OrderService;
use EasyWeChat\Payment\Application;
use Illuminate\Http\Request;

class OrderController extends BaseController
{
    protected $order ;

    public function __construct(OrderResitory $resitory)
    {
        $this->order = $resitory ;
    }

    /**
     * @SWG\Post(
     *      path="/order/submit",
     *      tags={"order"},
     *      operationId="order.submit",
     *      summary="提交订单",
     *      description="",
     *      security={{"api_key": {"scope"}}},
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
     *                  property="dog_id",
     *                  type="string",
     *                  description="狗编号",
     *              ),
     *               @SWG\Property(
     *                  property="address_id",
     *                  type="string",
     *                  description="地址编号",
     *              ),
     *               @SWG\Property(
     *                  property="payment",
     *                  type="string",
     *                  enum="{'weixin','alipay'}",
     *                  description="支付方式",
     *              ),
     *               @SWG\Property(
     *                  property="shipping_type",
     *                  type="string",
     *                  enum="{0,1,2}",
     *                  description="配送方式0外地，1同城，2自提",
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
     *                  @SWG\Property(property="order_no", type="string", description="订单编号"),
     *              )
     *          )
     *      ),
     * )
     */
    public function submit(OrderRequest $request)
    {
        // 地址
        if( ($address = OrderService::checkAddress($request->input("address_id"))) === false)
        {
            return $this->responseFailed("非法地址");
        }
        // 狗
        if( ($dog = OrderService::checkDog($request->input("dog_id"))) === false)
        {
            return $this->responseFailed("非法犬编号");
        }
        // 用户
        if($dog->user_id == \Auth::id())
        {
            return $this->responseFailed("不能购买自己的狗");
        }

        $shipping_type = $request->input("shipping_type");
        $payment = $request->input("payment");
        $res = OrderService::makeOrder($address , $dog ,$shipping_type , $payment , \Auth::user());
        if($res === false)
        {
            return $this->responseFailed("订单创建失败");
        }
        else{
            return $this->responseData(['order_no' => $res->order_no]);
        }
    }

    /**
     * @SWG\Get(
     *      path="/user/order/list",
     *      tags={"user"},
     *      operationId="user.order_list",
     *      summary="用户订单列表",
     *      description="",
     *      consumes={"application/json"},
     *      produces={"application/json"},
     *      security={{"api_key": {"scope"}}},
     *     @SWG\Parameter(
     *          in="query",
     *          name="order_status",
     *          description="不传表示获取全部订单。订单状态,0已提交，1已支付,2已发货，3已收货，4已评价，5订单取消，6发起退货，7已退货",
     *          required=false,
     *          type="string"
     *      ),
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
     *          description="结果集",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(property="code", type="integer", description="状态码"),
     *              @SWG\Property(property="message", type="string", description="状态信息"),
     *              @SWG\Property(property="data", type="object",
     *                  @SWG\Property(property="list", type="array",
     *                      @SWG\Items(type="object",
     *                          @SWG\Property(property="order_no", type="string", description="订单编号"),
     *                          @SWG\Property(property="consignee_name", type="string", description="收货人"),
     *                          @SWG\Property(property="consignee_mobile", type="string", description="收货人联系方式"),
     *                          @SWG\Property(property="consignee_address", type="string", description="收货人地址"),
     *                          @SWG\Property(property="buyer_message", type="string", description="买家留言"),
     *                          @SWG\Property(property="pay_status", type="integer", description="0未支付,1正在支付，2支付成功，3支付失败"),
     *                          @SWG\Property(property="order_status", type="integer", description="0已提交，1已支付,2已发货，3已收货，4已评价，5订单取消，6发起退货，7已退货"),
     *                          @SWG\Property(property="payment", type="string", description="支付方式"),
     *                          @SWG\Property(property="total_price", type="string", description="总支付价格"),
     *                          @SWG\Property(property="created_at", type="string", description="订单日期"),
     *                          @SWG\Property(property="order_dog", type="object",
     *                              @SWG\Property(property="category", type="string", description="品种"),
     *                              @SWG\Property(property="title", type="string", description="标题"),
     *                              @SWG\Property(property="birthday", type="string", description="生日"),
     *                              @SWG\Property(property="vaccine", type="string", description="疫苗数量"),
     *                              @SWG\Property(property="grade", type="string", description="品级 0-宠物 1-血统"),
     *                              @SWG\Property(property="thumb", type="string", description="缩略图"),
     *                              @SWG\Property(property="buyout_price", type="string", description="价格"),
     *                          ),
     *                      ),
     *                  ),
     *                  @SWG\Property(property="counts", type="object",
     *                      @SWG\Property(property="need_pay", type="integer", description="需要支付数量"),
     *                      @SWG\Property(property="need_confirm", type="integer", description="需要确认数量"),
     *                      @SWG\Property(property="need_comment", type="integer", description="需要评论数量"),
     *                  ),

     *              )
     *          )
     *      ),
     * )
     */
    public function userOrderList(Request $request)
    {
        $status = $request->input("order_status",null);
        $list = OrderService::getOrderListByStatus($status);
        $counts = OrderService::getOrderStatusCounts() ;
        return $this->responseData(['list' =>CollectionsTransformer::transforms($list->toArray())  , 'counts' => $counts]);
    }

    /**
     * @SWG\Post(
     *      path="/order/cancel",
     *      tags={"order"},
     *      operationId="order.cancel",
     *      summary="取消订单",
     *      description="",
     *      consumes={"application/json"},
     *      produces={"application/json"},
     *      security={{"api_key": {"scope"}}},
     *     @SWG\Parameter(
     *          in="body",
     *          name="data",
     *          description="",
     *          required=true,
     *          type="string",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="order_no",
     *                  type="string",
     *                  description="订单编号",
     *              ),
     *
     *          )
     *      ),
     *      @SWG\Response(
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
    public function cancelOrder(OrderNoRequest $request)
    {
        $order_no = $request->input("order_no");
        if(!\Gate::allows("handle-order" , $order_no))
        {
            return $this->responseFailed('无权操作');
        }

        if(OrderService::cancenOrder($order_no))
        {
            return $this->success([],0,'操作成功');
        }
        return $this->failed("操作失败");
    }


    /**
     * @SWG\Get(
     *      path="/order/detail",
     *      tags={"order"},
     *      operationId="order.order_detail",
     *      summary="订单详情",
     *      description="<img src='https://attachments.tower.im/tower/8f78b9f10d8f4943a7724fd813884bc1?version=auto&filename=image.png'>",
     *      consumes={"application/json"},
     *      produces={"application/json"},
     *      security={{"api_key": {"scope"}}},
     *     @SWG\Parameter(
     *          in="query",
     *          name="order_no",
     *          description="订单编号",
     *          required=false,
     *          type="string",
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="结果集",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(property="code", type="integer", description="状态码"),
     *              @SWG\Property(property="message", type="string", description="状态信息"),
     *              @SWG\Property(property="data", type="object",
     *                  @SWG\Property(property="order_no", type="string", description="订单编号"),
     *                  @SWG\Property(property="consignee_name", type="string", description="收货人"),
     *                  @SWG\Property(property="consignee_mobile", type="string", description="收货人联系方式"),
     *                  @SWG\Property(property="consignee_address", type="string", description="收货人地址"),
     *                  @SWG\Property(property="buyer_message", type="string", description="买家留言"),
     *                  @SWG\Property(property="pay_status", type="integer", description="0未支付,1正在支付，2支付成功，3支付失败"),
     *                  @SWG\Property(property="order_status", type="integer", description="0已提交，1已支付,2已发货，3已收货，4已评价，5订单取消，6发起退货，7已退货"),
     *                  @SWG\Property(property="payment", type="string", description="支付方式"),
     *                  @SWG\Property(property="total_price", type="string", description="总支付价格"),
     *                  @SWG\Property(property="order_dog", type="object",
     *                      @SWG\Property(property="category", type="string", description="品种"),
     *                      @SWG\Property(property="title", type="string", description="标题"),
     *                      @SWG\Property(property="birthday", type="string", description="生日"),
     *                      @SWG\Property(property="vaccine", type="string", description="疫苗数量"),
     *                      @SWG\Property(property="grade", type="string", description="品级 0-宠物 1-血统"),
     *                      @SWG\Property(property="thumb", type="string", description="缩略图"),
     *                      @SWG\Property(property="buyout_price", type="string", description="价格"),
     *                  ),
     *              )
     *          )
     *      ),
     * )
     */
    public function orderDetail(IdRequest $request)
    {
        $order_no = $request->input("order_no", 0) ;
        if(!\Gate::allows('handle-order', $order_no))
        {
            return $this->responseFailed('not access allowed');
        }
        $order = $this->order->getDetail($order_no);
        return $this->responseData($order->toArray());
    }


    /**
     * @SWG\Post(
     *      path="/order/pay",
     *      tags={"order"},
     *      operationId="order.cancel",
     *      summary="支付订单",
     *      description="",
     *      consumes={"application/json"},
     *      produces={"application/json"},
     *      security={{"api_key": {"scope"}}},
     *     @SWG\Parameter(
     *          in="body",
     *          name="data",
     *          description="",
     *          required=true,
     *          type="string",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="order_no",
     *                  type="string",
     *                  description="订单编号",
     *              ),
     *
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
     *                  @SWG\Property(property="payment", type="string", description="支付方式  weixin 或者 alipay"),
     *                  @SWG\Property(property="weixin", type="object",
     *                      @SWG\Property(property="appid", type="string", description="应该是apiKey"),
     *                      @SWG\Property(property="mchId", type="string", description="商户编号"),
     *                      @SWG\Property(property="nonceStr", type="string", description="随机字符"),
     *                      @SWG\Property(property="sign", type="string", description="签名"),
     *                      @SWG\Property(property="orderId", type="string", description="预支付id"),
     *                      @SWG\Property(property="timestamp", type="string", description="时间戳 多次支付尝试下是否正确"),
     *                      @SWG\Property(property="package", type="string", description="此处内容固定显示"),
     *                  ),
     *                  @SWG\Property(property="alipay", type="object",
     *                      @SWG\Property(property="orderInfo", type="string", description="支付信息"),
     *                  ),
     *
     *              ),
     *          )
     *      ),
     * )
     */


    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function pay(PayRequest $request)
    {
        $order_no = $request->input('order_no');//传入订单ID
        $order = Orders::where([
            'order_no' => $order_no
        ])->first(); //找到该订单
        $order_no =rand(100000,9999999); //拼一下订单号
        if ($order->payment == 'weixin') {
            $app = new Application(config('wechat.payment.default'));
            $wechat_order = $app->order;

            $out_trade_no = $order_no; //拼一下订单号
            $attributes = [
                'trade_type'       => 'APP', // JSAPI，NATIVE，APP...
                'body'             => '购买CSDN产品',
//            'detail'           => $order->, //我这里是通过订单找到商品详情，你也可以自定义
                'out_trade_no'     => $out_trade_no,
                'total_fee'        => 1, //因为是以分为单位，所以订单里面的金额乘以100
                // 'notify_url'       => 'http://xxx.com/order-notify', // 支付结果通知网址，如果不设置则会使用配置里的默认地址
                // 'openid'           => '当前用户的 openid', // trade_type=JSAPI，此参数必传，用户在商户appid下的唯一标识，
                // ...
            ];

            $result =$wechat_order->unify($attributes);
            if ($result['return_code'] == 'SUCCESS'){
                $result['timestamp'] = time();
                $result['package'] = "Sign=WXPay";



                $returnData = [
                    'appid' => $result['appid'],
                    'noncestr' => $result['nonce_str'],
                    'package' => "Sign=WXPay",
                    'partnerid' => $result['mch_id'],
                    'prepayid' => $result['prepay_id'],
                    'timestamp' => time(),
                    'key' => config('wechat.payment.default.key'),

                ];
//            $sign = strtoupper(call_user_func_array('md5', [urldecode(http_build_query($returnData))]));
                $sign = strtoupper(call_user_func_array('md5', [urldecode(http_build_query($returnData))]));
                $resultData  = [
                    'appid' => $result['appid'],
                    'orderId' => $returnData['prepayid'],
                    'mchId' => $returnData['partnerid'],
                    'nonceStr' => $returnData['noncestr'],
                    'timeStamp' => $returnData['timestamp'],
                    'package' => $returnData['package'],
                    'sign' => $sign,
                ];
                return $this->responseData(['payment'=> 'weixin','weixin' => $resultData]);

            }
        }
        if ($order->payment == 'alipay') {
            // 创建支付单。
            $alipay = app('alipay.mobile');
            $alipay->setOutTradeNo($order_no);
            $alipay->setTotalFee(0.01);
            $alipay->setSubject('goods_name');
            $alipay->setBody('goods_description');

            // 返回签名后的支付参数给支付宝移动端的SDK。
            return $this->responseData(['payment'=> 'alipay','alipay' => [
                'orderInfo' =>$alipay->getPayPara()
            ]]);
        }

        return $this->responseFailed();
    }


    public function payTest()
    {

        $app = new Application(config('wechat.payment.default'));
        $wechat_order = $app->order;

        $out_trade_no = rand(100000,9999999); //拼一下订单号
        $attributes = [
            'trade_type'       => 'APP', // JSAPI，NATIVE，APP...
            'body'             => '购买CSDN产品',
//            'detail'           => $order->, //我这里是通过订单找到商品详情，你也可以自定义
            'out_trade_no'     => $out_trade_no,
            'total_fee'        => 1, //因为是以分为单位，所以订单里面的金额乘以100
            // 'notify_url'       => 'http://xxx.com/order-notify', // 支付结果通知网址，如果不设置则会使用配置里的默认地址
            // 'openid'           => '当前用户的 openid', // trade_type=JSAPI，此参数必传，用户在商户appid下的唯一标识，
            // ...
        ];

        $result =$wechat_order->unify($attributes);
        if ($result['return_code'] == 'SUCCESS'){
            $result['timestamp'] = time();
            $result['package'] = "Sign=WXPay";

            $returnData = [
                'appid' => $result['appid'],
                'noncestr' => $result['nonce_str'],
                'package' => "Sign=WXPay",
                'partnerid' => $result['mch_id'],
                'prepayid' => $result['prepay_id'],
                'timestamp' => time(),
                'key' => config('wechat.payment.default.key'),

            ];
//            $sign = strtoupper(call_user_func_array('md5', [urldecode(http_build_query($returnData))]));
            $sign = strtoupper(call_user_func_array('md5', [urldecode(http_build_query($returnData))]));
            $resultData  = [
                'orderId' => $returnData['prepayid'],
                'mchId' => $returnData['partnerid'],
                'nonceStr' => $returnData['noncestr'],
                'timeStamp' => $returnData['timestamp'],
                'package' => $returnData['package'],
                'sign' => $sign,
            ];
            return $this->responseData($resultData);

        }
        return $this->responseFailed();
    }
}























