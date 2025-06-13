<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Documents extends Model
{
    use HasFactory;

    protected $table = "documents";
    protected $fillable = [
        'id_user_logged',
        'id_module',
        'id_record',

        'name',
        'file',
        'size',
        'type',
        'path',
        'comment',

        'active',
        'deleted',
    ];
    public function users(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Users::class, 'id_record');
    }
    public function modules(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Modules::class, 'id_module'); // дефинирање однос многу на еден
    }
}
