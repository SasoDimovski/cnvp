<?php

namespace Modules\Record\Dto;

use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;

class RecordDto
{
    public ?int $id_user_logged;
    public ?int $id_user;
    public ?int $id_module;
    public string $title;
    public ?string $slug;
    public ?string $subtitle;
    public ?string $intro;
    public ?string $text;
    public ?UploadedFile $picture = null;
    public ?int $main;
    public ?int $cover;
    public int $active;

    public static function fromRequest(Request $request): self
    {
        $dto = new self();
        $dto->id_user_logged  = $request->input('id_user_logged');
        $dto->id_user = $request->input('id_user');
        $dto->id_module = $request->input('id_module');
        $dto->title = $request->input('title');
        $dto->slug = $request->input('slug');
        $dto->subtitle = $request->input('subtitle');
        $dto->intro = $request->input('intro');
        $dto->text = $request->input('text');
        $dto->picture = $request->file('picture');
        $dto->active = (int)$request->input('active');
        $dto->cover = (int)$request->input('cover');
        $dto->main = (int)$request->input('main');
        return $dto;
    }
}

