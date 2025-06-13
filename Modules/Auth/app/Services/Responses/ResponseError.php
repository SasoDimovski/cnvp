<?php

namespace Modules\Auth\Services\Responses;

class ResponseError
{
    public string $status = "error";
    public function __construct(public string $method, public $class, public array $data = [])
    {
    }
}
