<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailType extends Model
{
    use HasFactory;

    protected $table = "_email_type";
    protected $fillable = [

        'name',
        'description',

        'active',
        'deleted',
    ];
}
