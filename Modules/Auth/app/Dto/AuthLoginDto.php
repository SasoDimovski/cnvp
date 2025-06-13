<?php

namespace Modules\Auth\Dto;

use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;

class AuthLoginDto
{
    public string $username;
    public string $password;

    public static function fromRequest(Request $request): self
    {
        $dto = new self();
        $dto->username = $request->input('username');
        $dto->password = $request->input('password');
        return $dto;
    }
}

