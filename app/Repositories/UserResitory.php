<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/22
 * Time: 16:00
 */
namespace App\Repsitories ;

use App\BaseModel;
use App\Http\Requests\UpdateUserInfoRequest;
use App\User;
use Bosnadev\Repositories\Eloquent\Repository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserResitory extends Repository
{
    public function model()
    {
        return User::class ;
    }

    public function setExistModel(Model $eloquent)
    {
        return $this->model = $eloquent;
    }
    public function register(array $data)
    {
        try {
            $r = $this->create($data);
            return $r;
        }
        catch (\Exception $exception) {

            return false;
        }
    }

    public function createOrUpdateUserInfo($data)
    {
            $userInfo = $this->findUserInfo();
            if ($userInfo) {
                $this->updateUserInfo($data);
                return $userInfo;
            }
            $this->createUserInfo($data);
            return $userInfo;

    }

    public function findUserInfo()
    {
        return $this->model->userInfo()->first();
    }

    public function createUserInfo($data)
    {
        return $this->model->userInfo()->create($data);
    }

    public function updateUserInfo($data)
    {
        return $this->model->userInfo()->update($data);
    }
    /**
     * 通过qqopenid获取用户
     */
    public function getByQQ($openid)
    {
        return $this->model->qqopenid($openid)->first();
    }

    /**
     * 获取用户信息
     */
    public function getByMobile($mobile)
    {
        return $this->model->mobile($mobile)->first();
    }

    /**
     * 获取用户信息
     */
    public function getByWx($openid)
    {
        return $this->model->wxopenid($openid)->first();
    }

    public function setQQinfo(User $user ,Request $request)
    {
        $user->qq_openid = $request->input('qq_openid') ;
        $user->qq_headimgurl = $request->input('qq_headimgurl', '');
        $user->qq_name = $request->input('qq_name', '');
        return $user->save();
    }

    public function setWxinfo(User $user ,Request $request)
    {
        $user->wx_openid = $request->input('wx_openid') ;
        $user->wx_headimgurl = $request->input('wx_headimgurl', '');
        $user->wx_name = $request->input('wx_name', '');
        return $user->save();
    }

}
