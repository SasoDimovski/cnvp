<?php

namespace Modules\Activities\Dto;

use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;

class ActivitiesDto
{
    public int $id;
    public string $name;
    public int $type;
    public ?string $dateinserted;
    public ?string $dateupdated;
    public ?string $insertedby;
    public ?string $updatedby;

    public static function fromRequest(Request $request): self
    {
        $dto = new self();
        $dto->id = (int)$request->input('id');
        $dto->name = $request->input('name');
        $dto->type = (int)$request->input('type');
        $dto->dateinserted = $request->input('dateinserted');
        $dto->dateupdated = $request->input('dateupdated');
        $dto->insertedby = $request->input('insertedby');
        $dto->updatedby = $request->input('updatedby');

        return $dto;
    }
}

