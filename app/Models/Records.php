<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Projects;

class Records extends Model
{
    use HasFactory;
    public $timestamps = true;
    const CREATED_AT = 'dateinserted';
    const UPDATED_AT = 'dateupdated';

    protected $fillable = [
        'id',
        'id_group',
        'id_country',
        'project',
        'assignment',
        'activity',
        'duration',
        'date',
        'year',
        'note',

        'dateofapproval',
        'approvedby',
        'lockrecord',

        'insertedby',
        'updatedby',
        'dateinserted',
        'dateupdated',

        'deleted',


    ];
    public function insertedByUser(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Users::class, 'insertedby', 'id');
    }

    public function updatedByUser(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Users::class, 'updatedby', 'id');
    }

    public function approvedByUser(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Users::class, 'approvedby', 'id');
    }

    public function assignments(): \Illuminate\Database\Eloquent\Relations\belongsTo
    {
        return $this->belongsTo(Assignments::class, 'assignment','id');
    }

    public function activities(): \Illuminate\Database\Eloquent\Relations\belongsTo
    {
        return $this->belongsTo(Activities::class, 'activity','id');
    }

    public function projects(): \Illuminate\Database\Eloquent\Relations\belongsTo
    {
        return $this->belongsTo(Projects::class, 'project','id');
    }
    public function countries(): \Illuminate\Database\Eloquent\Relations\belongsTo
    {
        return $this->belongsTo(Countries::class, 'id_country','id');
    }
    public function calendar(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Calendar::class, 'date', 'date');
    }
}
