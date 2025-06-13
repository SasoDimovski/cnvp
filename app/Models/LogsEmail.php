<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogsEmail extends Model
{
    use HasFactory;
    protected $table = "logs_email";
    protected $fillable = [
        'id_user',
        'id_email_type',
        'content',

        'active',
        'deleted',
    ];
}
