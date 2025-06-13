<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Groups extends Model
{
    use HasFactory;

    protected $table = "groups";
    protected $fillable = [
        'title',
        'description',
        'active',
        'deleted',
    ];

    public function users(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Users::class, 'modules_users', 'group_id', 'user_id'); // дефинирање однос еден на многу
    }
    public function modules(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Modules::class, 'groups_modules', 'group_id', 'module_id'); // дефинирање однос еден на многу
    }
}
