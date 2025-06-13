<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Calendar extends Model
{
    use HasFactory;

    protected $table = "calendar";
    protected $fillable = [
        'year',
        'day',
        'date',
        'lock_',
        'created_at',
        'updated_at',
    ];

    public function countries(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(
            Countries::class,
            'calendar_countries',  // Pivot табела
            'id_calendar',    // Foreign key што покажува кон Calendar
            'id_country' // Foreign key во pivot што покажува кон Countries
        );
    }


}
