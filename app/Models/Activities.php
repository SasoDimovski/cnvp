<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activities extends Model
{
    use HasFactory;

    public $timestamps = true;
    const string CREATED_AT = 'dateinserted'; // Промена на `created_at` во `dateinserted`
    const string UPDATED_AT = 'dateupdated'; // Промена на `updated_at` во `dateupdated`
    protected $fillable = [
        'name',
        'project',
        'type',
        'deleted',
        'dateinserted',
        'insertedby',
        'dateupdated',
        'updatedby',

    ];
    // Активноста припаѓа на повеќе Проекти  (може да ја има во повеќе проекти) (Many to Many)
    public function projects(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(
            Projects::class,
            'projects_activities',  // Pivot табела
            'id_activity',  // Foreign key во pivot што покажува кон Activity
            'id_project'    // Foreign key што покажува кон Project
        );
    }

    // Активноста може да ја има во повеќе записи (Records)
    public function records(): \Illuminate\Database\Eloquent\Relations\hasMany
    {
        return $this->hasMany(Records::class, 'activity','id');
    }
}
