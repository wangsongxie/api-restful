<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Swagger\Annotations\Get;

class SwaggerController extends Controller
{
    public function getJSON()
    {
        $swagger = \Swagger\scan(app_path('/'));

        return response()->json($swagger, 200);
    }
}
