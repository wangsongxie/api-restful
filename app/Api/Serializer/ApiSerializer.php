<?php
/**
 * Created by PhpStorm.
 * User: DevKang
 * Date: 2017/5/2
 * Time: 23:25
 */

namespace App\Api\Serializer;


use League\Fractal\Serializer\ArraySerializer;

class ApiSerializer extends ArraySerializer
{
    protected $code;

    protected $message;

    public function __construct($code = 0, $message = 'success')
    {
        $this->code = $code;
        $this->message = $message;
    }

    public function collection($resourceKey, array $data)

    {

        return [
            'code' => $this->code,
            'message' => $this->message,
            'data' => $data
        ];

    }

    public function item($resourceKey, array $data)

    {
        return [
            'code' => $this->code,
            'message' => $this->message,
            'data' => $data
        ];


    }
}