<?php

namespace App\Jobs;

use App\Sms;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Mockery\Exception;
use Yunpian\Sdk\YunpianClient;

class SmsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $mobile ;

    protected $content ;

    protected $code ;

    protected $type ;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($mobile , $code , $type)
    {
        $this->mobile = $mobile ;
        $this->code = $code ;
        $this->content = "【淘狗网】您的验证码是" . $code ;
        $this->type = $type ;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $client = YunpianClient::create(config('services.yunpian.key'));
        $param = [YunpianClient::MOBILE => $this->mobile , YunpianClient::TEXT => $this->content];
        $res = $client->sms()->single_send($param);
        if(!$res->isSucc())
        { // 不成功
            return false ;
        }
        else{
            $sms = new Sms();
            $sms->mobile = $this->mobile ;
            $sms->type = $this->type ;
            $sms->code = $this->code ;
            $sms->status = 0 ;
            $sms->save();
            return true ;
        }
    }
}
