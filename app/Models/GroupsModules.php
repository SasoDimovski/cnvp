<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupsModules extends Model
{
    use HasFactory;
    protected $table = "groups_modules";

    protected $fillable = [
        'group_id',
        'module_id',

        'active',
        'deleted',
    ];
}
