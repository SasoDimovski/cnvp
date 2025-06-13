<?php

namespace Modules\Projects\Dto;

use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;

class ProjectsDto
{
    public int $id;
    public int $type;
    public string $name;
    public ?string $description;
    public ?string $code;
    public ?string $start_date;
    public ?string $end_date;
    public ?string $deleted;
    public ?string $dateinserted;
    public ?string $dateupdated;
    public ?string $insertedby;

    public ?string $updatedby;
    public ?int $active;

    public static function fromRequest(Request $request): self
    {
        $dto = new self();
        $dto->id = (int)$request->input('id');
        $dto->type = (int)$request->input('type');
        $dto->name = $request->input('name');
        $dto->description = $request->input('description');
        $dto->code = $request->input('code');
        $dto->start_date = $request->input('start_date');
        $dto->end_date = $request->input('end_date');
        $dto->deleted = $request->input('deleted');
        $dto->dateinserted = $request->input('dateinserted');
        $dto->dateupdated = $request->input('dateupdated');
        $dto->insertedby = $request->input('insertedby');
        $dto->updatedby = $request->input('updatedby');
        $dto->active = (int)$request->input('active');

        return $dto;
    }
}

