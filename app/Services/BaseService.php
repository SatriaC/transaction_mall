<?php

namespace App\Services;

class BaseService
{
    protected $env;
    protected $productionEnv = 'production';
    protected $connection = 'mysql';

    public function __construct()
    {
        $this->env = config('app.env');
    }

    public function responseMessage($message, $statusCode, $isSuccess = false, $data = [])
    {
        return response()->json(
            [
                "message" => $message,
                "success" => $isSuccess,
                "data" => $data
            ],
            $statusCode
        );
    }
}
