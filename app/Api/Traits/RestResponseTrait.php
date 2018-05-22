<?php

namespace App\Api\Traits;

/**
 * Created by PhpStorm.
 * User: DevKang
 * Date: 2017/10/12
 * Time: 21:23
 */

trait RestResponseTrait
{
    public function responseCollection(Collection $collection, TransformerAbstract $transformer)
    {
        return $this->response->collection($collection, $transformer, [], function ($resource, Manager $fractal) {
            $fractal->setSerializer(new ApiSerializer());
        });
    }

    public function responseItem($item, TransformerAbstract $transformer)
    {
        return $this->response->item($item, $transformer, [], function ($resource, Manager $fractal) {
            $fractal->setSerializer(new ApiSerializer());
        });
    }

    public function responsePaginate(Paginator $paginator, TransformerAbstract $transformer)
    {
        return $this->response->paginator($paginator, $transformer, [], function ($resource, Manager $fractal) {
            $fractal->setSerializer(new ApiSerializer());
        });
    }

    public function responseData(array $data, $code = 0, $message = 'success', $status = 200)
    {
        return response()->json([
            'code' => $code,
            'message' => $message,
            'data' => $data
        ], $status);
    }

    public function responseSuccess($message = 'success')
    {
        return $this->responseMessage(0, $message);
    }

    public function responseFailed($message = 'failed')
    {
        return $this->responseMessage(2, $message, 500);
    }

    public function responseError($message = 'error')
    {
        return $this->responseMessage(1, $message, 500);
    }

    public function responseMessage($code, $message, $status = 200)
    {
        return response()->json([
            'code' => $code,
            'message' => $message,
        ], $status);
    }

    public function responseNotFound($message = 'not found')
    {
        return response()->json([
            'code' => 404,
            'message' => $message,
        ], 404);
    }

    public function noAuthenticate($message = 'token无效') {
        return response()->json(['code' => 401, 'message' => $message] , 422);
    }

    public function responseValiateError($message = '数据验证失败') {
        return response()->json(['code' => 422, 'message' => $message] , 422);
    }
}