<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Projects extends Model
{
    use HasFactory;
    const string CREATED_AT = 'dateinserted'; // Промена на `created_at` во `dateinserted`
    const string UPDATED_AT = 'dateupdated'; // Промена на `updated_at` во `dateupdated`

    protected $fillable = [
        'id',
        'name',
        'description',
        'code',
        'type',
        'start_date',
        'end_date',
        'deleted',
        'dateinserted',
        'dateupdated',
        'insertedby',
        'updatedby',
        'active',

    ];
    // Проект има повеќе Assignments
    public function assignments(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Assignments::class, 'project','id');
    }
    // Проект има повеќе Activities (Many to Many)
    public function activities(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Activities::class, 'projects_activities', 'id_project', 'id_activity'); // дефинирање однос еден на многу
    }

    // Проект може да го има во повеќе Records
    public function records(): \Illuminate\Database\Eloquent\Relations\hasMany
    {
        return $this->hasMany(Records::class, 'project','id');
    }
}
