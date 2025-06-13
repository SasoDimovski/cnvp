<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assignments extends Model
{
    use HasFactory;
    public $timestamps = true;
    const string CREATED_AT = 'dateinserted'; // Промена на `created_at` во `dateinserted`
    const string UPDATED_AT = 'dateupdated'; // Промена на `updated_at` во `dateupdated`

    protected $fillable = [
        'name',
        'description',
        'code',
        'start_date',
        'end_date',
        'project',
        'deleted',
        'dateinserted',
        'insertedby',
        'dateupdated',
        'updatedby',

    ];
    // Задачата може да ја има само во еден Проект
    public function projects(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Projects::class, 'project','id');
    }

    // Задачата може да ја има во повеќе записи (Records)
    public function records(): \Illuminate\Database\Eloquent\Relations\hasMany
    {
        return $this->hasMany(Records::class, 'assignment','id');
    }
}
