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
use App\Http\Requests\UpdateUserInfoRequest;
use App\Http\Requests\VerifyRequest;
use App\Region;
use App\Repsitories\SmsResitory;
use App\Repsitories\UserResitory;
use App\Services\UserService;
use App\Sms;
use App\UserIdentify;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class RegionController extends BaseController
{
    /**
     * @SWG\Get(
     *      path="/regions/all_with_pinyin",
     *      tags={"region"},
     *      operationId="region",
     *      summary="获取全部城市",
     *      description="获取全部城市",
     *      consumes={"application/json"},
     *      produces={"application/json"},
     *      @SWG\Response(
     *          response=200,
     *          description="结果集",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(property="code", type="integer", description="状态码"),
     *              @SWG\Property(property="message", type="string", description="状态信息"),
     *              @SWG\Property(property="data", type="object",
     *                  @SWG\Property(property="topCities", type="array",
     *                      @SWG\Items(type="object",
     *                          @SWG\Property(property="id", type="integer", description="地域ID"),
     *                          @SWG\Property(property="name", type="string", description="城市名称"),
     *                          @SWG\Property(property="pinyin", type="string", description="城市拼音"),
     *                      ),
     *                  ),
     *                  @SWG\Property(property="cities", type="array",
     *                      @SWG\Items(type="object",
     *                          @SWG\Property(property="id", type="integer", description="地域ID"),
     *                          @SWG\Property(property="name", type="string", description="城市名称"),
     *                          @SWG\Property(property="pinyin", type="string", description="城市拼音"),
     *                      ),
     *                  ),
     *              ),
     *          )
     *      ),
     * )
     */

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function getSecondPinYinRegion()
    {
        $provinces = Region::where([
            'parent_region_id' => 0
        ])->get();
        $provinceIds = [];

        foreach ($provinces as $province) {
            $provinceIds[] = $province->region_id;
        }

        $cities = Region::whereIn('parent_region_id',$provinceIds)->get()->toArray();
        $topCities = [];
        foreach ($cities as $key => $city) {
            if (in_array($city['name'], ['市辖区', '县'])) {
                $topCities[$city['parent_region_id']] = Region::where('region_id', $city['parent_region_id'])->first()->toArray();
                unset($cities[$key]);
            }
        }
        $topCities = array_map(function($data) {
            return [
                'id' => $data['region_id'],
                'city' => $data['name'],
                'pinyin' => $data['pinyin'],
            ];
        },array_values($topCities));
        $cities = array_map(function($data) {
            return [
                'id' => $data['region_id'],
                'city' => $data['name'],
                'pinyin' => $data['pinyin'],
            ];
        }, array_values($cities));
        return ['topCitys' => $topCities, 'citys' => $cities];
    }
}
