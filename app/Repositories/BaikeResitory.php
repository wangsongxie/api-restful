<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/29
 * Time: 15:59
 */

namespace App\Repsitories;
use App\BaikeDetail;
use App\Videos;
use Bosnadev\Repositories\Eloquent\Repository;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;


class BaikeResitory extends Repository
{
    public function model()
    {
        return BaikeDetail::class ;
    }

    public function preFind($id)
    {
        $r = $this->find($id);
        if(!$r)
        {
            throw new ModelNotFoundException();
        }
        return $r;
    }
    
    // 详情
    public function getDetail($id)
    {
        return $this->preFind($id) ;
    }

    public function getVideos($id)
    {
        $r = $this->preFind($id);
        return $r->videos()->get();
    }

    public function getDefaultPrice($id)
    {
        $r = $this->preFind($id);
        return $r->price()->orderBy("month","asc")->limit(6)->offset(0)->groupBy("id","month")->get();
    }

    // $type = 1 || 2
    public function getYearPrice($id ,$type)
    {
        $r = $this->preFind($id);
        $date = Carbon::now()->subYear($type)->toDateString();
        return $r->price()->where([['month' , '>=' , $date]])->orderBy("month","asc")->groupBy("month")->get();
    }
}
