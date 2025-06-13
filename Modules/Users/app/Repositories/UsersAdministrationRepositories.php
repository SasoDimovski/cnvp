<?php

namespace Modules\Users\Repositories;

use App\Models\Groups;
use App\Models\Modules;
use App\Models\Users;

class UsersAdministrationRepositories
{

    public function assignedGroups($id_user,$id_language)
    {
//        $user = Users::where(['id' => $id_user])->first();
//        return $user->groups()->with('modules')->get();

        // Прво го добиваме корисникот и неговите групи
        $user = Users::with(['groups.modules' => function ($query) use ($id_language) {
            $query->where('modules.active', 1)
                ->where('modules.deleted', 0)
                ->where('modules.id_language', $id_language)
//                ->where('modules.id_modules_type', 1)
                ->with('type', 'design')
                ->orderBy('modules.id_parent')
                ->orderBy('modules.created_at');
        }])->find($id_user);

        // Ако корисникот нема групи, врати празна колекција
        if (!$user) {
            return collect();
        }

        // Изгради дрво структура за модулите на секоја група
        $groups = $user->groups->map(function ($group) {
            if ($group->modules->isNotEmpty()) {
                $group->modules = $this->buildModuleTree($group->modules);
            }
            return $group;
        });

        return $groups;

    }

    public function unassignedGroups($id_user, $id_language)
    {
//        $user = Users::where(['id' => $id_user])->first();
//        $assignedGroupIds = $user->groups->pluck('id')->flatten()->toArray();
//        $unassignedGroups = Groups::whereNotIn('id', $assignedGroupIds)->get();
//        return $unassignedGroups;

        // Ги земаме ID-ата на групите што му се доделени на корисникот
        $user = Users::with('groups')->find($id_user);

        if (!$user) {
            return collect(); // Врати празна колекција ако корисникот не постои
        }

        $assignedGroupIds = $user->groups->pluck('id')->toArray();

        // Земаме групи кои не се доделени на корисникот
        $unassignedGroups = Groups::with(['modules' => function ($query) use ($id_language) {
            $query->where('modules.active', 1)
                ->where('modules.deleted', 0)
                ->where('modules.id_language', $id_language)
//                ->where('modules.id_modules_type', 1)
                ->with('type', 'design')
                ->orderBy('modules.id_parent')
                ->orderBy('modules.created_at');
        }])
            ->whereNotIn('id', $assignedGroupIds)
            ->get();

        // Преработуваме модули во дрво структура
        $unassignedGroups = $unassignedGroups->map(function ($group) {
            if ($group->modules->isNotEmpty()) {
                $group->modules = $this->buildModuleTree($group->modules);
            }
            return $group;
        });

        return $unassignedGroups;

    }

    public function allGroups($id_language)
    {
        //$groups = Groups::all();
        $groups = Groups::with(['modules' => function ($query) use ($id_language) {
            $query->where('modules.active', 1) // Додадете префикс на табелата
            ->where('modules.deleted', 0)
                ->where('modules.id_language', $id_language)
//                ->where('modules.id_modules_type', 1)
                ->with('type', 'design')
                ->orderBy('modules.id_parent') // Префикс на табелата
                ->orderBy('modules.created_at');
        }])->get();

        $groups = $groups->map(function ($group) {
            if ($group->modules->isNotEmpty()) {
                $group->modules = $this->buildModuleTree($group->modules);
            }
            return $group;
        });
        return $groups;
    }

    public function allModules($id_language)
    {
        $modules = Modules::all()->filter(function ($module) use ($id_language) {
            return $module->active == 1
                && $module->deleted == 0
                && $module->id_language == $id_language;
                //&& $module->id_modules_type == 1
        })
            ->load('type', 'design')
            ->sortBy('created_at');
        return $this->buildModuleTree($modules);

    }



    public function assignedModulesAll($userId,$id_language)
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

        return $this->buildModuleTree($allModules);
    }
    public function assignedModulesModules($userId,$id_language)
    {
        // Модули директно доделени на корисникот
        $user = Users::find($userId);
        $allModules = $user->modules->filter(function ($module) use ($id_language) {
            return $module->active == 1
                && $module->deleted == 0
                && $module->id_language == $id_language
                && $module->id_modules_type == 1;
        })
            ->load('type', 'design')
            ->sortBy('created_at');
        return $this->buildModuleTree($allModules);
    }
    public function unassignedModulesModules($userId,$id_language)
    {
        // Модули директно доделени на корисникот
        $user = Users::find($userId);
        $allModules = $user->modules->filter(function ($module) use ($id_language) {
            return $module->active == 1
                && $module->deleted == 0
                && $module->id_language == $id_language
                && $module->id_modules_type == 1;
        })
            ->load('type', 'design')
            ->sortBy('created_at')->pluck('id'); // Извадете ги само ID-ата на доделените модули

        $unassignedModules = Modules::whereNotIn('id', $allModules)
            ->where('active', 1)
            ->where('deleted', 0)
            ->where('id_language', $id_language)
            ->get();

        return $this->buildModuleTree($unassignedModules);
    }
    public function buildModuleTree($modules)
    {
        // Групирање на модулите според `id_parent`
        $grouped = $modules->groupBy('id_parent');
        // dd($grouped);
        // Рекурзивна функција за изградување на дрвото
        $buildTree = function ($parentId) use (&$buildTree, $grouped) {
            return $grouped->get($parentId, collect())->map(function ($module) use (&$buildTree) {
                return [
                    'id' => $module->id,
                    'id_parent' => $module->id_parent,
                    'title' => $module->title,
                    'id_modules_type' => $module->id_modules_type,
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
        // Изградување на дрвото почнувајќи од коренските модули (оние со `id_parent = null`)
        return $buildTree(null);
    }

}
