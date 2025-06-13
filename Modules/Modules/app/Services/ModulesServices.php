<?php

namespace Modules\Modules\Services;

use App\Models\Users;
use Illuminate\Support\Facades\DB;
use Modules\Modules\Repositories\ModulesRepositories;

class ModulesServices
{
    public function __construct(public ModulesRepositories $modulesServices)
    {
    }
    // WITH ELOQUENT
/*    public function isUserModuleAreAttached($userId,$moduleId, $id_language)
    {
        //dd($id_language);
        $user = Users::find($userId);
        if (!$user) {
            return false; // Корисникот не постои
        }
        // Модули директно доделени на корисникот
        $userModules = $user->modules;
        // Модули преку групите на корисникот
        $groupModules = $user->groups->flatMap(function ($group) {
            return $group->modules;
        });
        // Унија на модулите
        $allModules = $userModules->merge($groupModules)
            ->unique('id')
            ->filter(function ($module) use ($id_language) {
                return $module->active == 1
                    && $module->deleted == 0
                    && $module->id_language == $id_language
                    && $module->id_modules_type == 1;
            });
        // Проверка дали дадениот модул (moduleId) е во унијата
        return $allModules->contains('id', $moduleId);
    }*/


// WITH DB
    public function isUserModuleAreAttached($userId,$moduleId, $id_language)
    {
       // dd('$userId:'.$userId.'/'.'$moduleId:'.$moduleId);
        // Проверка за директно доделен модул
        $existsDirect = DB::table('modules_users')
            ->join('modules', 'modules.id', '=', 'modules_users.module_id')
            ->where('modules_users.user_id', $userId)
            ->where('modules.id', $moduleId)
            ->where('modules.id_language', $id_language)
            ->where('modules.active', 1)
            ->where('modules.deleted', 0)
            ->exists();
        //dd($existsDirect);
        // Проверка за модул преку групите
        $existsThroughGroups = DB::table('groups_users')
            ->join('groups_modules', 'groups_users.group_id', '=', 'groups_modules.group_id')
            ->join('modules', 'modules.id', '=', 'groups_modules.module_id')
            ->where('groups_users.user_id', $userId)
            ->where('modules.id', $moduleId)
            ->where('modules.id_language', $id_language)
            ->where('modules.active', 1)
            ->where('modules.deleted', 0)
            ->exists();

       //dd($existsThroughGroups);
        // Враќа true ако е исполнет било кој од условите
        return $existsDirect || $existsThroughGroups;
    }


    public function getAllModulesByIdUser($userId,$id_language)
    {
        $user = Users::find($userId);
        // Модули директно доделени на корисникот
        $userModules = $user->modules;
        // Модули преку групите на корисникот
        $groupModules = $user->groups->flatMap(function ($group) {
            return $group->modules;
        });
        //Унија на модулите
        $allModules = $userModules->merge($groupModules)
            ->unique('id')
            ->filter(function ($module) use ($id_language) {
                return $module->active == 1
                    && $module->deleted == 0
                    && $module->id_language == $id_language
                    && $module->id_modules_type == 1;
            })
            ->load('type', 'design')
            ->sortBy('created_at');

        $moduleTree = $this->buildModuleTree($allModules);
        return $moduleTree;
    }
    public function buildModuleTree($modules)
    {
        $grouped = $modules->groupBy('id_parent');
        $buildTree = function ($parentId) use (&$buildTree, $grouped) {
            return $grouped->get($parentId, collect())->map(function ($module) use (&$buildTree) {
                return [
                    'id' => $module->id,
                    'id_parent' => $module->id_parent,
                    'title' => $module->title,
                    'link' => $module->link,
                    'slug' => $module->slug,
                    'description' => $module->description,
                    'type' => $module->type ? $module->type->title : null,
                    'design' => $module->design ? $module->design->title : null,
                    'icon' => $module->design->icon ?? null,
                    'button_color' => $module->design->button_color ?? null,
                    'text_color' => $module->design->text_color ?? null,
                    'children' => $buildTree($module->id), // Рекурзивно добивање на децата
                ];
            });
        };
        return $buildTree(null);
    }
    public function getModulesById($id_module)
    {
        return $this->modulesServices->getModulesById($id_module);
    }
    public function getLanguagesByLang($lang)
    {
        return $this->modulesServices->getLanguagesByLang($lang);
    }
}
