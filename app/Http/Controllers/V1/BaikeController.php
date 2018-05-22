<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/29
 * Time: 16:02
 */

namespace App\Http\Controllers\V1;


use App\Http\Requests\IdRequest;
use App\Repsitories\BaikeResitory;

class BaikeController extends BaseController
{

    protected $baike;

    public function __construct(BaikeResitory $baikeResitory)
    {
        $this->baike = $baikeResitory;
    }

    /**
     * @SWG\Get(
     *      path="/baike/detail",
     *      tags={"guest"},
     *      operationId="baike.detail",
     *      summary="百科详情",
     *      description="<img src='https://attachments.tower.im/tower/dbe2ad96e391406fb77486e6eac513dd?version=auto&filename=image.png' >",
     *      consumes={"application/json"},
     *      produces={"application/json"},
     *     @SWG\Parameter(
     *          in="query",
     *          name="id",
     *          description="data",
     *          required=true,
     *          type="string",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="id",
     *                  type="string",
     *                  description="狗分类编号",
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
     *                  ref="#/definitions/mBaikeDetail"
     *              ),
     *          )
     *      ),
     * )
     */
    public function detail(IdRequest $request)
    {
        $detail = $this->baike->getDetail($request->input("id"));

        return $this->success(['detail' => $detail]);
    }
    /**
     * @SWG\Get(
     *      path="/baike/videos",
     *      tags={"guest"},
     *      operationId="baike.videos",
     *      summary="百科视频",
     *      description="<img src='https://attachments.tower.im/tower/e0fd0b8437434229af630540f8c5e607?version=auto&filename=image.png' >",
     *      consumes={"application/json"},
     *      produces={"application/json"},
     *     @SWG\Parameter(
     *          in="query",
     *          name="id",
     *          description="data",
     *          required=true,
     *          type="string",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="id",
     *                  type="string",
     *                  description="狗分类编号",
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
     *                  ref="#/definitions/mVideos"
     *              ),
     *          )
     *      ),
     * )
     */
    public function videos(IdRequest $request)
    {
        $videos = $this->baike->getVideos($request->input("id"));
        return $this->success(['detail' => $videos]);
    }
    /**
     * @SWG\Get(
     *      path="/baike/price",
     *      tags={"guest"},
     *      operationId="baike.price",
     *      summary="百科价格趋势",
     *      description="<img src='https://attachments.tower.im/tower/d277abc068174c7f9d81b5aa9cf71a23?version=auto&filename=image.png' >",
     *      consumes={"application/json"},
     *      produces={"application/json"},
     *     @SWG\Parameter(
     *          in="query",
     *          name="id",
     *          description="data",
     *          required=true,
     *          type="string",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="id",
     *                  type="string",
     *                  description="狗分类编号",
     *              )
     *          )
     *      ),@SWG\Parameter(
     *          in="query",
     *          name="type",
     *          description="data",
     *          required=false,
     *          type="string",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="type",
     *                  type="string",
     *                  description="类型：1||2  对应1年 2年",
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
     *                  ref="#/definitions/mBaikePrice"
     *              ),
     *          )
     *      ),
     * )
     */
    public function price(IdRequest $request)
    {
        $type = $request->input("type", null);
        if(is_null($type))
        {
            $res = $this->baike->getDefaultPrice($request->input("id"));
        }
        else{
            if(!in_array($type , ['1','2']))
            {
                return $this->failed("invalid type");
            }
            $res = $this->baike->getYearPrice($request->input("id"),$type);
        }
        return $this->success(['price' => $res ]);
    }
}
