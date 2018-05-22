<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/22
 * Time: 16:00
 */
namespace App\Repsitories ;

use App\Dog;
use App\DogCollect;
use App\DogsCategory;
use Bosnadev\Repositories\Eloquent\Repository;
use Illuminate\Support\Facades\DB;

class DogResitory extends Repository
{
    public function model()
    {
        return Dog::class ;
    }

    public function getAllCategories()
    {
        return DogsCategory::all();
    }

    public function getPages($cate_id = null , $area_id = null , $vaccine = null)
    {
        $map = [];
        if(!is_null($cate_id))
        {
            $map [] = ['cate_id' , '=' , $cate_id];
        }
        if(!is_null($vaccine))
        {
            $map [] = ['vaccine' , '=' , $vaccine] ;
        }
        $query = $this->model->with('dogInfo')->with('files')->with('shopInfo')->with('categoryInfo')->where($map)->onsell()->orderBy("id","desc");
        if(!empty($area_id))
        {
            $query->leftJoin("user_identify", function($q) use($area_id){
                $q->on("dogs.user_id" , "=","user_identify.user_id")
                    ->where(function($q) use($area_id){
                        $q->orWhere("province_id" , $area_id);
                        $q->orWhere("city_id" , $area_id);
                        $q->orWhere("area_id" , $area_id);
                    });
            });
        }
        $pages = $query->paginate(20,['title','sex','buyout_price','market_price','cate_id',"dogs.user_id as user_id" ,"dogs.id as id"]);
        return $pages;
    }

    public function getDetail($id)
    {
        return $this->model->with('dogInfo')->with('files')->with('shopInfo')->with('categoryInfo')->onsell()->findOrFail($id);
    }

    public function collect($id)
    {
        $dog = Dog::find($id);
        if(!$dog)
        {
            return false;
        }
        $exist = DogCollect::where('dog_id',$id)->where('user_id',\Auth::id())->first();
        if($exist)
        {
            return $exist->delete();
        }
        else{
            return DogCollect::create(['dog_id' => $id , 'user_id' => \Auth::id()]);
        }
    }

    public function softDeleteDog($ids)
    {
        DB::beginTransaction();
        try {
            foreach ($ids as $id)
            {
                $dog = Dog::find($id);
                if(!$dog->delete())
                {
                    DB::rollBack();
                    return false;
                }
            }
            DB::commit();
            return true;
        }
        catch (\Exception $exception) {
            DB::rollBack();
            return false;
        }
    }
}
