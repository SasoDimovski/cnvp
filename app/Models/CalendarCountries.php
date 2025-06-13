<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CalendarCountries extends Model
{
    use HasFactory;
    protected $table = "calendar_countries";

    protected $fillable = [
        'id_calendar',
        'id_country',
        'active',
        'deleted',
    ];
}
