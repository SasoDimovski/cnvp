<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Countries extends Model
{
    use HasFactory;

    protected $table = "_countries";
    protected $fillable = [
        'code_s',
        'code_l',
        'name',

        'active',
        'deleted',
    ];

    // Корисникот припаѓа на повеќе Администрации (земји)  (може да ја има во повеќе проекти) (Many to Many)
    public function users(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(
            Users::class,
            'users_countries',  // Pivot табела
            'id_country',    // Foreign key што покажува кон Countries
             'id_user' // Foreign key во pivot што покажува кон Users
        );
    }
    public function records(): \Illuminate\Database\Eloquent\Relations\hasMany
    {
        return $this->hasMany(Records::class, 'id_country','id');
    }

    public function calendar(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(
            Calendar::class,
            'calendar_countries',  // Pivot табела
            'id_country',    // Foreign key што покажува кон Countries
            'id_calendar' // Foreign key во pivot што покажува кон Calendar
        );
    }
}
