<?php

namespace App\Http\Controllers\V1;

use App\Dog;
use App\Http\Requests\IdRequest;
use App\Repsitories\ShopResitory;
use App\Transformers\DogTransformer;
use App\Transformers\ShopTransformer;
use App\UserIdentify;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ShopController extends BaseController
{

    protected $shop ;

    public function __construct(ShopResitory $shop)
    {
        $this->shop = $shop ;
    }

    /**
     * @SWG\Definition(
     *      definition="user_identify",
     *      type="object",
     *          @SWG\Property(property="user_id", type="integer", description="用户id,商家id"),
     *          @SWG\Property(property="sell_type", type="integer", description="商家类型：1个人 2商家"),
     *          @SWG\Property(property="shop_desc", type="string", description="商家简介"),
     *          @SWG\Property(property="shop_name", type="string", description="商家名称"),
     *          @SWG\Property(property="is_valid", type="integer", description="是否认证 1-认证 0-否"),
     *          @SWG\Property(property="address", type="string", description="地址"),
     *          @SWG\Property(property="stars", type="integer", description="星级"),
     *          @SWG\Property(property="logo", type="string", description="logo"),
     * )
     */


    /**
     * @SWG\Get(
     *      path="/shop",
     *      tags={"guest"},
     *      operationId="shop",
     *      summary="商家列表",
     *      description="<img src='https://attachments.tower.im/tower/ab4d84f19efc4e08b01dcebe826b56d2?filename=%E5%95%86%E5%AE%B6.png'>",
     *      consumes={"application/json"},
     *      produces={"application/json"},
     *     @SWG\Parameter(
     *          in="query",
     *          name="region_id",
     *          description="市所对应的 region_id , 420100有数据",
     *          required=false,
     *          type="string",
     *      ),
     *     @SWG\Parameter(
     *          in="query",
     *          name="page",
     *          description="页码",
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
     *                  @SWG\Property(property="total", type="integer", description="总条数"),
     *                  @SWG\Property(property="per_page", type="integer", description="每页显示数量"),
     *                  @SWG\Property(property="current_page", type="integer", description="当前页码"),
     *                  @SWG\Property(property="last_page", type="integer", description="最后一页"),
     *                  @SWG\Property(property="next_page_url", type="string", description="下一页地址"),
     *                  @SWG\Property(property="prev_page_url", type="string", description="上一页地址"),
     *                  @SWG\Property(property="from", type="integer", description="开始"),
     *                  @SWG\Property(property="to", type="integer", description="结束"),
     *                  @SWG\Property(property="lists", type="array",
     *                      @SWG\Items(type="object",
     *                          @SWG\Property(property="dogs", type="object",
     *                              @SWG\Property(property="id", type="integer", description="产品id"),
     *                              @SWG\Property(property="title", type="integer", description="产品标题"),
     *                              @SWG\Property(property="market_price", type="string", description="市场价"),
     *                              @SWG\Property(property="buyout_price", type="string", description="一口价"),
     *                              @SWG\Property(property="dog_info", type="object",
     *                                  @SWG\Property(property="thumb", type="string", description="缩略图"),
     *                              ),
     *                          ),
     *                              @SWG\Property(property="user_id", type="integer", description="用户id 也为店铺id"),
     *                              @SWG\Property(property="sell_type", type="integer", description="商家类型：0未定义，1个人，2商家"),
     *                              @SWG\Property(property="shop_name", type="string", description="商家名称"),
     *                              @SWG\Property(property="is_valid", type="integer", description="是否已经认证 0-未认证 1-已经认证"),
     *                              @SWG\Property(property="trade_num", type="integer", description="交易量购买记录"),
     *                              @SWG\Property(property="comments_count", type="integer", description="评论数量"),
     *                              @SWG\Property(property="stars", type="integer", description="星级"),
     *                              @SWG\Property(property="address", type="string", description="地址"),
     *                              @SWG\Property(property="logo", type="string", description="logo"),
     *                      ),
     *
     *                  ),
     *              )
     *          )
     *      ),
     * )
     */
    public function shopList(Request $request)
    {
        $city_id = $request->input("city_id");
        if(!$city_id)
        {
            $city_id = null ;
        }
        $list = $this->shop->getShopList($city_id)->toArray();
        return $this->responseData(ShopTransformer::transforms($list));
    }
    /**
     * @SWG\Get(
     *      path="/shop/{shop_id}/dogs",
     *      tags={"guest"},
     *      operationId="shop.dogs",
     *      summary="商家狗狗列表",
     *      description="<img src='https://attachments.tower.im/tower/d81ea9ed5800466a9c59e615f705b103?version=auto&filename=image.png'>",
     *      consumes={"application/json"},
     *      produces={"application/json"},
     *     @SWG\Parameter(
     *          in="path",
     *          name="shop_id",
     *          description="店铺id",
     *          required=true,
     *          type="integer",
     *      ),
     *     @SWG\Parameter(
     *          in="query",
     *          name="time",
     *          description="最新排序asc 递增，desc递减",
     *          required=false,
     *          type="string",
     *      ),
     *     @SWG\Parameter(
     *          in="query",
     *          name="price",
     *          description="价格排序 asc 递增，desc递减",
     *          required=false,
     *          type="string",
     *
     *      ),
     *     @SWG\Parameter(
     *          in="query",
     *          name="page",
     *          description="页码",
     *          required=false,
     *          type="string",
     *
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="结果集",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(property="code", type="integer", description="状态码"),
     *              @SWG\Property(property="message", type="string", description="状态信息"),
     *              @SWG\Property(property="data", type="object",
     *                  @SWG\Property(property="total", type="integer", description="总条数"),
     *                  @SWG\Property(property="per_page", type="integer", description="每页显示数量"),
     *                  @SWG\Property(property="current_page", type="integer", description="当前页码"),
     *                  @SWG\Property(property="last_page", type="integer", description="最后一页"),
     *                  @SWG\Property(property="next_page_url", type="string", description="下一页地址"),
     *                  @SWG\Property(property="prev_page_url", type="string", description="上一页地址"),
     *                  @SWG\Property(property="from", type="integer", description="开始"),
     *                  @SWG\Property(property="to", type="integer", description="结束"),
     *                  @SWG\Property(property="lists", type="array",
     *                      @SWG\Items(type="object",
     *                          ref="#/definitions/dogInfo"
     *                      )
     *                  ),
     *              )
     *          )
     *      ),
     * )
     */
    public function shopDogs(IdRequest $request, $shop_id)
    {
        $time = $request->input("time", 'desc'); // asc desc
        $price = $request->input("price", null); // asc desc

        $shop = UserIdentify::where([
            'user_id' => $shop_id
        ])->first();
        if(is_null($shop))
        {
            throw new NotFoundHttpException("未找到该店铺");
        }
        $dogs = Dog::where([
            'user_id' =>$shop_id
        ])->with(['dogInfo'])->with('files');
        if ($price) {
            $dogs->orderBy('buyout_price', $price);
        }

        $dogs->orderBy('id', $time);
        $dogs = $dogs->get();
        return $this->responseData(DogTransformer::transforms($dogs->toArray()));
    }

    /**
     * @SWG\Get(
     *      path="/shop/{shop_id}/detail",
     *      tags={"guest"},
     *      operationId="shop.detail",
     *      summary="商家详情",
     *      description="<img src='https://attachments.tower.im/tower/1b93903a5a7a4c418349a26ddc6c8480?version=auto&filename=image.png'>",
     *      consumes={"application/json"},
     *      produces={"application/json"},
     *     @SWG\Parameter(
     *          in="path",
     *          name="shop_id",
     *          description="店铺id",
     *          required=true,
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
     *                   ref="#/definitions/user_identify"
     *              )
     *          )
     *      ),
     * )
     */


    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function shopDetail($shop_id)
    {
        $userIdentify = UserIdentify::where([
            'user_id' => $shop_id
        ])->first();

        if (!$userIdentify) {
            return $this->responseNotFound();
        }
        return $this->responseData(ShopTransformer::transform($userIdentify->toArray()));
    }

    /**
     * @SWG\Get(
     *      path="/shop/on_sell",
     *      tags={"auth"},
     *      operationId="shop.onsell",
     *      summary="正在出售列表",
     *      description="<img src='https://attachments.tower.im/tower/d5a21009c9bc4edf8794598b2abe9918?filename=%E5%87%BA%E5%94%AE%E4%B8%AD%E7%9A%84%E5%AE%9D%E8%B4%9D.png'>",
     *      consumes={"application/json"},
     *      produces={"application/json"},
     *      security={{"api_key": {"scope"}}},
     *     @SWG\Parameter(
     *          in="query",
     *          name="cate_id",
     *          description="分类id, 不传为所有分类",
     *          required=false,
     *          type="string",
     *      ),
     *     @SWG\Parameter(
     *          in="query",
     *          name="time",
     *          description="最新排序asc 递增，desc递减",
     *          required=false,
     *          type="string",
     *      ),
     *     @SWG\Parameter(
     *          in="query",
     *          name="price",
     *          description="价格排序 asc 递增，desc递减",
     *          required=false,
     *          type="string",
     *      ),
     *     @SWG\Parameter(
     *          in="query",
     *          name="page",
     *          description="页码",
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
     *                  @SWG\Property(property="total", type="integer", description="总条数"),
     *                  @SWG\Property(property="per_page", type="integer", description="每页显示数量"),
     *                  @SWG\Property(property="current_page", type="integer", description="当前页码"),
     *                  @SWG\Property(property="last_page", type="integer", description="最后一页"),
     *                  @SWG\Property(property="next_page_url", type="string", description="下一页地址"),
     *                  @SWG\Property(property="prev_page_url", type="string", description="上一页地址"),
     *                  @SWG\Property(property="from", type="integer", description="开始"),
     *                  @SWG\Property(property="to", type="integer", description="结束"),
     *                  @SWG\Property(property="lists", type="array",
     *                      @SWG\Items(type="object",
     *                          @SWG\Property(property="id", type="integer", description="产品id"),
     *                          @SWG\Property(property="title", type="string", description="产品标题"),
     *                          @SWG\Property(property="sex", type="integer", description="0-未知 1-公  2-母"),
     *                          @SWG\Property(property="buyout_price", type="string", description="一口价"),
     *                          @SWG\Property(property="market_price", type="string", description="市场价"),
     *                          @SWG\Property(property="cate_id", type="integer", description="分类id"),
     *                          @SWG\Property(property="user_id", type="integer", description="用户id"),
     *                          @SWG\Property(property="dog_info", type="object",
     *                              @SWG\Property(property="dog_id", type="integer", description="狗狗id"),
     *                              @SWG\Property(property="thumb", type="string", description="缩略图"),
     *                          ),
     *                      ),
     *
     *                  ),
     *              )
     *          )
     *      ),
     * )
     */
    public function onSell(Request $request)
    {
        $dogCate = $request->input("cate_id");
        $time = $request->input("time"); // asc desc
        $price = $request->input("price"); // asc desc
        if(!in_array($time, ['asc','desc']))
        {
            $time = "desc" ;
        }
        if(!in_array($price,['asc','desc']))
        {
            $price = null ;
        }
        $dogs = $this->shop->getShopOnSell($dogCate , $time , $price);
        $dogs = $dogs->setCollection($dogs->getCollection()->makeVisible('created_at'));
        return $this->responseData(DogTransformer::transforms($dogs->toArray()));
    }





}
