<?php
/**
 * Created by PhpStorm.
 * User: DevKang
 * Date: 2017/5/6
 * Time: 15:11
 */

namespace App\Api\Request;


use App\Api\Traits\RestResponseTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;
use Illuminate\Contracts\Validation\Validator;
class RestRequest extends FormRequest
{

    use RestResponseTrait;
    // 构造一个场景变量
    public $scene = 'add';

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function __construct(array $query = array(), array $request = array(), array $attributes = array(), array $cookies = array(), array $files = array(), array $server = array(), $content = null)
    {
        parent::__construct($query, $request, $attributes, $cookies, $files, $server, $content);

        $data = $this->json()->all();
        if (isset($data['id'])) {
            $this->scene = 'update';
        }
    }
    /**
     * Get the proper failed validation response for the request.
     *
     * @param  array  $errors
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function response(array $errors)
    {
        return $this->responseValiateError( current(current($errors)));
    }

    protected function failedValidation(Validator $validator)
    {
        throw new ValidationException($validator, $this->response(
            $this->formatErrors($validator)
        ));
    }

    /**
     * Format the errors from the given Validator instance.
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     * @return array
     */
    protected function formatErrors(Validator $validator)
    {
        return $validator->getMessageBag()->toArray();
    }

}