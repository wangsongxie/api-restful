<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/25
 * Time: 11:16
 */

namespace App\Http\Controllers\V1;


use App\Dog;
use App\DogCollect;
use App\DogsCategory;
use App\Http\Requests\DogDelRequest;
use App\Http\Requests\DogPublishRequest;
use App\Http\Requests\DogUpdateRequest;
use App\Http\Requests\IdRequest;
use App\Repsitories\DogResitory;
use App\Services\DogService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class DogController extends BaseController
{
    protected $dog;

    public function __construct(DogResitory $dog)
    {
        $this->dog = $dog;
    }

    /**
     * @SWG\Definition(
     *      definition="dog_category",
     *      type="object",
     *      @SWG\Property(property="id", type="integer", description="分类id"),
     *      @SWG\Property(property="name", type="string", description="分类名称"),
     *      @SWG\Property(property="thumb", type="string", description="分类缩略图"),
     *      @SWG\Property(property="pinyin", type="string", description="分类首字母"),
     *      @SWG\Property(property="is_hot", type="integer", description="是否热门：0-否 1-是"),
     *      @SWG\Property(property="article_cate_id", type="integer", description="关联文章分类id"),
     * )
     */


    /**
     * @SWG\Definition(
     *      definition="dogInfo",
     *      type="object",
     *      @SWG\Property(property="id", type="integer", description="产品id"),
     *      @SWG\Property(property="title", type="string", description="产品标题"),
     *      @SWG\Property(property="sex", type="integer", description="0-未知 1-公  2-母"),
     *      @SWG\Property(property="buyout_price", type="string", description="一口价"),
     *      @SWG\Property(property="market_price", type="string", description="市场价"),
     *      @SWG\Property(property="cate_id", type="integer", description="分类id"),
     *      @SWG\Property(property="user_id", type="integer", description="用户id"),
     *      @SWG\Property(property="files", type="object",
     *          @SWG\Property(property="url", type="string", description="文件url"),
     *          @SWG\Property(property="type", type="integer", description="文件类型：1-图片 2-视频"),
     *          @SWG\Property(property="dog_id", type="integer", description="关联狗狗id"),
     *      ),
     *      @SWG\Property(property="dog_info", type="object",
     *          @SWG\Property(property="dog_id", type="integer", description="狗狗id"),
     *          @SWG\Property(property="thumb", type="string", description="缩略图"),
     *          @SWG\Property(property="detail", type="string", description="狗狗详情"),
     *      ),
     * )
     */


    /**
     * @SWG\Definition(
     *      definition="dog_edit_data_model",
     *      type="object",
     *      @SWG\Property(property="id", type="integer", description="狗狗ID，此字段根据场景显示，例如发布没有此字段",),
     *      @SWG\Property(property="title", type="string", description="标题",),
     *      @SWG\Property(property="cate_id", type="integer", description="分类ID",),
     *      @SWG\Property(property="birthday", type="string",description="生日： 格式：2017-12-12",),
     *      @SWG\Property(property="vaccine", type="integer", description="疫苗次数", ),
     *      @SWG\Property( property="sex", type="integer", description="1-公 2-母", ),
     *      @SWG\Property(property="sterilization", type="integer", description="是否绝育，0-否 1-是",),
     *      @SWG\Property(property="grade", type="integer", description="宠物级别：0-普通宠物 1-血统级",),
     *      @SWG\Property(property="body_size", type="integer", description="体型大小：0-小 1-中 2-大",),
     *      @SWG\Property(property="insect", type="integer", description="驱虫次数",),
     *      @SWG\Property(property="is_presell", type="integer", description="是否预售：0-否 1-是",),
     *      @SWG\Property(property="health_ensure_days", type="integer", description="健康保证天数",),
     *      @SWG\Property(property="buyout_price", type="number", description="一口价",),
     *      @SWG\Property(property="market_price", type="number", description="市场价",),
     *      @SWG\Property(property="presell_price", type="number", description="预定价格：当勾选预售时需要输入此值",),
     *     @SWG\Property(
     *          property="dog_info",
     *          type="object",
     *          @SWG\Property(property="detail", type="string", description="商品详情",),
     *      ),
     *
     *      @SWG\Property(property="files", type="array",
     *          @SWG\Items(
     *              type="object",
     *              @SWG\Property(property="type", type="integer", description="1-图片 2-视频",),
     *              @SWG\Property(property="url", type="string", description="文件地址",),
     *          ),
     *      ),
     * )
     */



    /**
     * @SWG\Get(
     *      path="/dog/categories",
     *      tags={"dog"},
     *      operationId="dog",
     *      summary="获取狗狗分类列表",
     *      consumes={"application/json"},
     *      produces={"application/json"},
     *      @SWG\Response(
     *          response=200,
     *          description="结果集",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(property="code", type="integer", description="状态码"),
     *              @SWG\Property(property="message", type="string", description="状态信息"),
     *              @SWG\Property(property="data", type="array",
     *                  @SWG\Items(type="object",
     *                      ref="#/definitions/dog_category"
     *                  ),
     *
     *              ),
     *          )
     *      ),
     * )
     */

    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getCategory()
    {
        return $this->dog->getAllCategories();
    }

    /**
     * @SWG\Get(
     *      path="/home",
     *      tags={"guest"},
     *      operationId="home",
     *      summary="获取首页列表",
     *      description="<img src='https://attachments.tower.im/tower/04a7779f7d574b11963923878dcb43aa?version=auto&filename=image.png'>",
     *      consumes={"application/json"},
     *      produces={"application/json"},
     *      @SWG\Parameter(
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
     *              @SWG\Property(property="list", type="object",
     *                  ref="#/definitions/mdog"
     *              ),
     *              @SWG\Property(property="category", type="object",
     *                  ref="#/definitions/mdog_category"
     *              ),
     *          )
     *      ),
     * )
     */
    public function index(Request $request)
    {
        // 分类
        $category = $this->dog->getAllCategories();
        // 成交行情
        $trades = [];

        // 列表 .
        $list = $this->dog->getPages();

        return $this->success(['list' => $list , 'category' => $category]);
    }

    /**
     * @SWG\Get(
     *      path="/dog/list",
     *      tags={"guest"},
     *      operationId="dog.list",
     *      summary="获取狗狗列表",
     *      description="<img src='https://attachments.tower.im/tower/04a7779f7d574b11963923878dcb43aa?version=auto&filename=image.png'>",
     *      consumes={"application/json"},
     *      produces={"application/json"},
     *      @SWG\Parameter(
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
     *     @SWG\Parameter(
     *          in="query",
     *          name="area_id",
     *          description="区域id",
     *          required=false,
     *          type="string",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="area_id",
     *                  type="string",
     *                  description="区域id",
     *              )
     *          )
     *      ),
     *     @SWG\Parameter(
     *          in="query",
     *          name="cate_id",
     *          description="犬种分类id",
     *          required=false,
     *          type="string",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="cate_id",
     *                  type="string",
     *                  description="犬种分类id",
     *              )
     *          )
     *      ),
     *     @SWG\Parameter(
     *          in="query",
     *          name="vaccine",
     *          description="疫苗次数",
     *          required=false,
     *          type="string",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="vaccine",
     *                  type="string",
     *                  description="疫苗次数",
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
     *                          @SWG\Property(property="files", type="object",
     *                              @SWG\Property(property="url", type="string", description="文件url"),
     *                              @SWG\Property(property="type", type="integer", description="文件类型：1-图片 2-视频"),
     *                              @SWG\Property(property="dog_id", type="integer", description="关联狗狗id"),
     *                          ),
     *                          @SWG\Property(property="dog_info", type="object",
     *                              @SWG\Property(property="dog_id", type="integer", description="狗狗id"),
     *                              @SWG\Property(property="thumb", type="string", description="缩略图"),
     *                              @SWG\Property(property="detail", type="string", description="狗狗详情"),
     *                          ),
     *                          @SWG\Property(property="shop_info", type="object",
     *                              @SWG\Property(property="user_id", type="integer", description="用户id 也为店铺id"),
     *                              @SWG\Property(property="sell_type", type="integer", description="商家类型：0未定义，1个人，2商家"),
     *                              @SWG\Property(property="shop_desc", type="string", description="商家简介"),
     *                              @SWG\Property(property="shop_name", type="string", description="商家名称"),
     *                              @SWG\Property(property="is_valid", type="integer", description="是否已经认证 0-未认证 1-已经认证"),
     *                              @SWG\Property(property="region_id", type="integer", description="所在地区id"),
     *                              @SWG\Property(property="trade_num", type="integer", description="交易量购买记录"),
     *                              @SWG\Property(property="comments_count", type="integer", description="评论数量"),
     *                              @SWG\Property(property="stars", type="integer", description="星级"),
     *                              @SWG\Property(property="logo", type="string", description="logo"),
     *                          ),
     *                          @SWG\Property(property="category_info", type="object",
     *                              @SWG\Property(property="id", type="integer", description="分类id"),
     *                              @SWG\Property(property="name", type="string", description="分类名称"),
     *                              @SWG\Property(property="thumb", type="string", description="分类缩略图"),
     *                              @SWG\Property(property="pinyin", type="string", description="首字母拼音"),
     *                              @SWG\Property(property="is_hot", type="integer", description="是否热门 0-否 1-热门"),
     *                          ),
     *                      ),
     *
     *                  ),
     *              )
     *          )
     *      ),
     * )
     */
    public function getDogList(Request $request)
    {
        $cate_id = $request->input("cate_id",null);
        $area_id = $request->input("area_id",null);
        $vaccine = $request->input("vaccine",null);
        // 列表 .
        $list = $this->dog->getPages($cate_id , $area_id , $vaccine);

        return $this->success(['list' => $list ]);
    }


    /**
     * @SWG\Get(
     *      path="/dog/detail",
     *      tags={"guest"},
     *      operationId="dog.detail",
     *      summary="宠物详情",
     *      description="<img src='https://attachments.tower.im/tower/86c6456a618743a89cfebb9bd61893fc?version=auto&filename=image.png'>",
     *      consumes={"application/json"},
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          in="query",
     *          name="id",
     *          description="data",
     *          required=false,
     *          type="string",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="id",
     *                  type="string",
     *                  description="编号",
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
     *                  @SWG\Property(property="id", type="integer", description="产品id"),
     *                  @SWG\Property(property="title", type="string", description="产品标题"),
     *                  @SWG\Property(property="sex", type="integer", description="0-未知 1-公  2-母"),
     *                  @SWG\Property(property="buyout_price", type="string", description="一口价"),
     *                  @SWG\Property(property="market_price", type="string", description="市场价"),
     *                  @SWG\Property(property="cate_id", type="integer", description="分类id"),
     *                  @SWG\Property(property="user_id", type="integer", description="用户id"),
     *                  @SWG\Property(property="files", type="object",
     *                      @SWG\Property(property="url", type="string", description="文件url"),
     *                      @SWG\Property(property="type", type="integer", description="文件类型：1-图片 2-视频"),
     *                      @SWG\Property(property="dog_id", type="integer", description="关联狗狗id"),
     *                  ),
     *                  @SWG\Property(property="dog_info", type="object",
     *                      @SWG\Property(property="dog_id", type="integer", description="狗狗id"),
     *                      @SWG\Property(property="thumb", type="string", description="缩略图"),
     *                      @SWG\Property(property="detail", type="string", description="狗狗详情"),
     *                  ),
     *                  @SWG\Property(property="shop_info", type="object",
     *                      @SWG\Property(property="user_id", type="integer", description="用户id 也为店铺id"),
     *                      @SWG\Property(property="sell_type", type="integer", description="商家类型：0未定义，1个人，2商家"),
     *                      @SWG\Property(property="shop_desc", type="string", description="商家简介"),
     *                      @SWG\Property(property="shop_name", type="string", description="商家名称"),
     *                      @SWG\Property(property="is_valid", type="integer", description="是否已经认证 0-未认证 1-已经认证"),
     *                      @SWG\Property(property="region_id", type="integer", description="所在地区id"),
     *                      @SWG\Property(property="trade_num", type="integer", description="交易量购买记录"),
     *                      @SWG\Property(property="comments_count", type="integer", description="评论数量"),
     *                      @SWG\Property(property="stars", type="integer", description="星级"),
     *                      @SWG\Property(property="logo", type="string", description="logo"),
     *                  ),
     *                  @SWG\Property(property="category_info", type="object",
     *                      @SWG\Property(property="id", type="integer", description="分类id"),
     *                      @SWG\Property(property="name", type="string", description="分类名称"),
     *                      @SWG\Property(property="thumb", type="string", description="分类缩略图"),
     *                      @SWG\Property(property="pinyin", type="string", description="首字母拼音"),
     *                      @SWG\Property(property="is_hot", type="integer", description="是否热门 0-否 1-热门"),
     *                  ),
     *              )
     *          )
     *      ),
     * )
     */
    public function detail(Request $request)
    {
        $dog = $this->dog->getDetail($request->input("id"));
        $collect = 0 ;
        if(!\Auth::guest())
        {
            $collect = DogCollect::where('dog_id',$dog->id)->where('user_id',\Auth::id())->first();
            if($collect)
            {
                $collect = 1;
            }
            else{
                $collect = 0 ;
            }
        }
        return $this->success(['detail' => $dog , 'has_collect' => $collect]);
    }




    /**
     * @SWG\Post(
     *      path="/dog/publish",
     *      tags={"dog"},
     *      operationId="dog.publish",
     *      summary="发布狗狗",
     *      description="<img src='https://attachments.tower.im/tower/ca97a842f97a4077a8473b6ed0e285ee?filename=%E5%8F%91%E5%B8%83%E5%AE%9D%E8%B4%9D.png'>",
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
     *              ref="#/definitions/dog_edit_data_model"
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
     *                  ref="#/definitions/muser_identify"
     *              )
     *          )
     *      ),
     * )
     */





    /**
     * @param DogPublishRequest $request
     * @return \Illuminate\Http\JsonResponse
     */

    public function publish(DogPublishRequest $request)
    {

        if(!Gate::allows("dog-publish"))
        {
            return $this->responseFailed("您还没有认证");
        }


        $data = $request->all();
        $data ['buyout_price'] = abs(round($data['buyout_price'] , 2));
        $data ['market_price'] = abs(round($data['market_price'],2));
        $data ['presell_price'] = abs(round($data['presell_price'],2));



        if ($dog = DogService::publish($data)) {

            return $this->responseSuccess("发布成功");

        } else {

            return $this->responseFailed("发布失败");

        }
    }


    /**
     * @SWG\get(
     *      path="/dog/{dog_id}/show",
     *      tags={"dog"},
     *      operationId="dog.update",
     *      summary="获取狗狗信息 编辑狗狗获取信息使用。",
     *      consumes={"application/json"},
     *      produces={"application/json"},
     *      security={{"api_key": {"scope"}}},
     *      @SWG\Parameter(
     *          description="评论ID",
     *          in="path",
     *          name="dog_id",
     *          required=true,
     *          type="integer",
     *          format="int64"
     *     ),
     *      @SWG\Response(
     *          response=200,
     *          description="结果集",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(property="code", type="integer", description="状态码"),
     *              @SWG\Property(property="message", type="string", description="状态信息"),
     *              @SWG\Property(property="data", type="object",
     *                   ref="#/definitions/dog_edit_data_model"
     *              )
     *          )
     *      ),
     * )
     */

    public function show($dog_id)
    {

        $dog = Dog::where('id', $dog_id)->with('dogInfo')->with('files')->first();

        if (!$dog) {
            return $this->responseNotFound('未找到');
        }
        return $this->responseData($dog->toArray());

    }


    /**
     * @SWG\Post(
     *      path="/dog/update",
     *      tags={"dog"},
     *      operationId="dog.update",
     *      summary="更新狗狗",
     *      description="<img src='https://attachments.tower.im/tower/ca97a842f97a4077a8473b6ed0e285ee?filename=%E5%8F%91%E5%B8%83%E5%AE%9D%E8%B4%9D.png'>",
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
     *              ref="#/definitions/dog_edit_data_model"
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

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(DogUpdateRequest $request)
    {
        if(!Gate::allows("dog-publish"))
        {
            return $this->responseFailed("您还没有认证");
        }


        $data = $request->all();
        $data ['buyout_price'] = abs(round($data['buyout_price'] , 2));
        $data ['market_price'] = abs(round($data['market_price'],2));
        $data ['presell_price'] = abs(round($data['presell_price'],2));



        if ($dog = DogService::update($data)) {

            return $this->responseSuccess("发布成功");

        } else {

            return $this->responseFailed("发布失败");

        }
    }
    /**
     * @SWG\Post(
     *      path="/dog/collect",
     *      tags={"auth"},
     *      operationId="dog.collect",
     *      summary="狗狗收藏||取消收藏",
     *      description="",
     *      consumes={"application/json"},
     *      produces={"application/json"},
     *      security={{"api_key": {"scope"}}},
     *     @SWG\Parameter(
     *          in="body",
     *          name="id",
     *          description="",
     *          required=true,
     *          type="string",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="id",
     *                  type="string",
     *                  description="狗id",
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
     *          )
     *      ),
     * )
     */
    public function collect(IdRequest $request)
    {
        $id = $request->input("id");
        if($this->dog->collect($id))
        {
            return $this->success([],0,'操作成功');
        }
        else{
            return $this->failed("操作失败");
        }
    }


    /**
     * @SWG\Post(
     *      path="/dog/delete",
     *      tags={"dog"},
     *      operationId="dog.del",
     *      summary="删除出售中的宝贝",
     *      description="<img src='https://attachments.tower.im/tower/7e94bfc2ff214b849dd59dd2c9973fc8?filename=%E5%88%A0%E9%99%A4%E5%87%BA%E5%94%AE%E4%B8%AD%E7%9A%84%E5%AE%9D%E8%B4%9D.png'>",
     *      consumes={"application/json"},
     *      produces={"application/json"},
     *      security={{"api_key": {"scope"}}},
     *     @SWG\Parameter(
     *          in="body",
     *          name="data",
     *          description="狗id",
     *          required=false,
     *          @SWG\Schema(
     *              type="object",
     *               @SWG\Property(property="dog_ids", type="array",
     *                   @SWG\Items(
     *                      type="integer"
     *                   )
     *               ),
     *          )
     *
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

    /**
     * @param DogDelRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function delDog(DogDelRequest $request)
    {
        $dog_ids = $request->input("dog_ids");

        foreach ($dog_ids as $id)
        {
            if(!\Gate::allows("dog-delete" , $id))
            {
                return $this->responseFailed("无权删除此狗狗");
            }
        }
        if($this->dog->softDeleteDog($dog_ids))
        {
            return $this->responseSuccess('删除成功') ;
        }
        return $this->responseFailed("删除失败");
    }



    /**
     * @SWG\get(
     *      path="/dog/{dog_id}/refresh",
     *      tags={"dog"},
     *      operationId="dog.update",
     *      description="<img src='https://attachments.tower.im/tower/24431b3ba8d44de89880adf45a87c8af?version=auto&filename=image.png' />",
     *      summary="刷新狗狗",
     *      consumes={"application/json"},
     *      produces={"application/json"},
     *      security={{"api_key": {"scope"}}},
     *      @SWG\Parameter(
     *          description="狗狗ID",
     *          in="path",
     *          name="dog_id",
     *          required=true,
     *          type="integer",
     *          format="int64"
     *     ),
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
    public function refresh()
    {
        return $this->responseSuccess();
    }
}
