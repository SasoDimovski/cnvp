<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModulesType extends Model
{
    use HasFactory;

    protected $table = "_modules_type";

    protected $fillable = [
        'title',
        'description',

        'active',
        'deleted',
    ];
    public function modules(): \Illuminate\Database\Eloquent\Relations\hasMany
    {
        return $this->hasMany(Modules::class, 'id_module'); // дефинирање однос многу на еден
    }

}
