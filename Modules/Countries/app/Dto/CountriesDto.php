<?php

namespace Modules\Countries\Dto;

use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;

class CountriesDto
{
    public int $id;
    public string $code_s;
    public ?string $code_l;
    public ?string $name;
    public ?string $active;
    public ?string $deleted;
    public ?string $created_at;
    public ?string $updated_at;

    public static function fromRequest(Request $request): self
    {
        $dto = new self();
        $dto->id = (int)$request->input('id');
        $dto->name = $request->input('name');
        $dto->code_s = $request->input('code_s');
        $dto->code_l = $request->input('code_l');
        $dto->active = $request->input('active');
        $dto->deleted = $request->input('deleted');
        $dto->created_at = $request->input('created_at');
        $dto->updated_at = $request->input('updated_at');

        return $dto;
    }
}

