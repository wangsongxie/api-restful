<?php
/**
 * author : rookiejin <mrjnamei@gmail.com>
 * createTime : 2017/11/22 12:52
 * description: ApiResponse.php - dog126-app-api
 */
namespace App\Api\Helpers\Api;
use Symfony\Component\HttpFoundation\Response as FoundationResponse;
use Response;

trait ApiResponse {
    /**
     * @var int
     */
    protected $status = FoundationResponse::HTTP_OK;

    protected $code = 0 ;

    protected $message = '';

    protected $data = [] ;

    public function setStatus($status)
    {
        $this->status = $status ;
        return $this ;
    }

    public function getStatus()
    {
        return $this->status ;
    }

    public function setMessage($message)
    {
        $this->message = $message ;
        return $this;
    }

    public function getMessage()
    {
        return $this->message ;
    }

    public function getData()
    {
        return $this->data ;
    }

    public function setData($data = [])
    {
        $this->data = $data ;
    }

    public function respond($header = [])
    {
        $data = [
            'code' => $this->getCode() ,
            'message' => $this->getMessage() ,
            'data' => $this->getData() ,
        ];
        return Response::json( $data , $this->getStatus() , $header) ;
    }

    public function setCode($code)
    {
        $this->code = $code ;
        return $this;
    }

    public function getCode()
    {
        return $this->code ;
    }

    public function success($data = [] , $code = 0 , $message = 'success', $status =  FoundationResponse::HTTP_OK )
    {
        $this->data = $data ;
        $this->setCode($code);
        $this->setMessage($message);
        $this->setStatus($status);
        return $this->respond() ;
    }

    public function failed($message = null , $code = null , $status = null)
    {
        if($status)
        {
            $this->setStatus($status) ;
        }
        if($message)
        {
            $this->setMessage($message);
        }
        if($code)
        {
            $this->setCode($code) ;
        }
        else{
            $this->setCode( -1 ) ;
        }
        return $this->respond();
    }

    public function internalError($message = "Internal Error!"){
        return $this->failed($message,-1 , FoundationResponse::HTTP_INTERNAL_SERVER_ERROR);
    }

    /*
     * @param string $message
     * @return mixed
     */
    public function notFond($message = 'Request Not Fond!')
    {
        return $this->failed($message,-1 ,Foundationresponse::HTTP_NOT_FOUND);
    }

}
