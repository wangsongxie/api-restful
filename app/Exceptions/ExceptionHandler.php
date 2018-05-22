<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/22
 * Time: 14:55
 */

namespace App\Exceptions;


use App\Api\Helpers\Api\ApiResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ExceptionHandler
{
    use ApiResponse;

    public $exception ;

    public $request ;

    public $response ;

    protected $report ;

    public function __construct(Request $request , \Exception $exception)
    {
        $this->request = $request ;
        $this->exception = $exception ;
    }

    public $doReport = [
        ModelNotFoundException::class => ["资源未找到" , 404]
    ];


    public function shouldReturn()
    {
        if(!($this->request->wantsJson()) || $this->request->ajax())
        {
            return false ;
        }
        // 验证错误
        foreach (array_keys($this->doReport) as $array_key) {
            if($this->exception instanceof $array_key)
            {
                $this->report = $array_key ;
                return true ;
            }
        }

        return false ;
    }

    public static function make(\Exception $e)
    {
        return new static(request() , $e);
    }

    public function report()
    {
        $message = $this->doReport[$this->report] ;
        return $this->failed($message [0] , $message [1]) ;
    }
}
