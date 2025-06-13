<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Modules extends Model
{
    use HasFactory;
    protected $table = "modules";
    protected $fillable = [
        'id_parent',
        'id_language',
        'id_modules_type',
        'id_design_type',
        'title',
        'slug',
        'description',
        'link',
        'active',
        'deleted',
    ];
    public function documents(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Documents::class, 'id_module'); // дефинирање однос еден на многу
    }

    public function users(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Users::class, 'modules_users', 'module_id', 'user_id'); // дефинирање однос еден на многу
    }
    public function groups(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Groups::class, 'groups_modules', 'module_id', 'group_id'); // дефинирање однос еден на многу
    }

    public function type(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(ModulesType::class, 'id_modules_type', 'id');
    }
    public function design(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(ModulesDesign::class, 'id_design_type', 'id');
    }

    public function children(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Modules::class, 'id_parent', 'id')->where('active', '=', '1')->where('deleted', '=', '0')->orderBy('created_at', 'DESC');
    }

    public static function search_in_multidimensional_array($search_value, $array, $id_path) {

        if(is_array($array) && count($array) > 0) {
            foreach($array as $key => $value) {
                $temp_path = $id_path;
                // Adding current key to search path
                array_push($temp_path, $key);
                // Check if this value is an array
                // with atleast one element
                if(is_array($value) && count($value) > 0) {
                    $res_path = (new static)->search_in_multidimensional_array($search_value, $value, $temp_path);
                    if ($res_path != null) {
                        return $res_path;
                    }
                }
                else if($value == $search_value) {
                    return join("-->", $temp_path);
                }
            }
        }
        return null;
    }
}
