<?php

namespace App\Services\Responses;

class ResponseSuccess
{
    public string $status = "success";
    public function __construct(public string $method, public $class,public array $data = [])
    {
    }
}
