<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/22
 * Time: 16:00
 */
namespace App\Repsitories ;

use App\Jobs\SmsJob;
use App\Sms;
use Bosnadev\Repositories\Eloquent\Repository;
use Carbon\Carbon;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Queue;
use Yunpian\Sdk\YunpianClient;

class SmsResitory extends Repository
{
    use DispatchesJobs ;
    protected $code ;

    public function model()
    {
        return Sms::class ;
    }

    public function generateCode()
    {
        $this->code = rand(111111,999999) ;
        return $this->code ;
    }

    public function getCode()
    {
        return $this->code;
    }

    public function validate( $mobile , $code , $type)
    {
        // 增加一个140手机号免验证码
        if (substr($mobile,0,3) == 140) {
            return true ;
        }
        if (app()->isLocal())
        {
            return true ;
        }
        $r = $this->model->validate($mobile, $type)->first();
        if(!$r){
            return false;
        }
        if($r->code != $code)
        {
            return false;
        }
        $r->status = 1 ;
        $r->save();
        return true;
    }
    
    /**
     * 发送短信
     */
    public function sendSms($mobile, $type)
    {
        $code = $this->generateCode() ;
//        // job
//        $job = (new SmsJob($mobile , $code , $type))->onQueue("sms");
//        Queue::push($job);
        $content = "【淘狗网】您的验证码是" . $code ;
        $client = YunpianClient::create(config('services.yunpian.key'));
        $param = [YunpianClient::MOBILE => $mobile , YunpianClient::TEXT => $content];
        $res = $client->sms()->single_send($param);
        if(!$res->isSucc())
        { // 不成功
            return false ;
        }
        else{
            $sms = new Sms();
            $sms->mobile = $mobile ;
            $sms->type = $type ;
            $sms->code = $code ;
            $sms->status = 0 ;
            $sms->save();
            return $code ;
        }
    }

    public function tooManyAttempts($mobile)
    {
        $has = $this->model->where([
            ['mobile' , '=' , $mobile],
            ['created_at' , '>' , Carbon::now()->subMinutes(1) ],
        ])->exists();
        if($has)
        {
            return true;
        }
        return false;
    }
}
