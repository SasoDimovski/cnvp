<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpirationTime extends Model
{
    use HasFactory;
    protected $table = "_expiration_time";
    protected $fillable = [
        'value',
        'name',
        'description',

        'active',
        'deleted',
    ];
    public function users(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Users::class, 'id_expiration_time');
    }
}
