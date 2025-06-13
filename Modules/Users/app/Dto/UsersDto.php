<?php

namespace Modules\Users\Dto;

use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;

class UsersDto
{
    public int $id;
    public int $id_user_logged;
    public int $id_module;
    public string $surname;
    public int $id_country;
    public ?int $id_expiration_time = null;
    public ?string $address = null;
    public ?string $phone = null;
    public ?UploadedFile $picture = null;
    public string $email;
    public ?string $email_verified_at = null;
    public string $username;
    public ?string $password = null;
    public ?string $password_reset_hash = null;
    public ?string $password_reset_hash_date = null;
    public ?string $password_reset_type = null;
    public ?string $verification_code = null;
    public ?string $verification_code_expire = null;
    public int $user_type;
    public int $active;

    public static function fromRequest(Request $request): self
    {
        $dto = new self();
        $dto->id = (int)$request->input('id');
        $dto->id_user_logged = (int)$request->input('id_user_logged');
        $dto->id_module = (int)$request->input('id_module');
        $dto->name = $request->input('name');
        $dto->surname = $request->input('surname');
        $dto->id_country = (int)$request->input('id_country');
        $dto->id_expiration_time = $request->input('id_expiration_time') ? (int)$request->input('id_expiration_time') : null;
        $dto->address = $request->input('address');
        $dto->phone = $request->input('phone');
        $dto->picture = $request->file('picture');
        $dto->email = $request->input('email');
        $dto->email_verified_at = $request->input('email_verified_at');
        $dto->username = $request->input('username');
        $dto->password = $request->input('password');
        $dto->password_reset_hash = $request->input('password_reset_hash');
        $dto->password_reset_hash_date = $request->input('password_reset_hash_date');
        $dto->password_reset_type = $request->input('password_reset_type');
        $dto->verification_code = $request->input('verification_code');
        $dto->verification_code_expire = $request->input('verification_code_expire');
        $dto->user_type = (int)$request->input('user_type');
        $dto->active = (int)$request->input('active');

        return $dto;
    }
}

