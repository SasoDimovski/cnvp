<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class ServicesAssignedModules
{
    public function getUserModuleIds($userId, $id_language): array
    {
        //dd($id_language);
        // Директно доделени модули
        $directModules = DB::table('modules_users')
            ->join('modules', 'modules.id', '=', 'modules_users.module_id')
            ->where('modules_users.user_id', $userId)
            ->where('modules.id_language', $id_language)
            ->where('modules.active', 1)
            ->where('modules.deleted', 0)
            ->where('modules.id_modules_type', 2)
            ->pluck('modules.id')
            ->toArray();

        // Модули доделени преку групи
        $groupModules = DB::table('groups_users')
            ->join('groups_modules', 'groups_users.group_id', '=', 'groups_modules.group_id')
            ->join('modules', 'modules.id', '=', 'groups_modules.module_id')
            ->where('groups_users.user_id', $userId)
            ->where('modules.id_language', $id_language)
            ->where('modules.active', 1)
            ->where('modules.deleted', 0)
            ->where('modules.id_modules_type', 2)
            ->pluck('modules.id')
            ->toArray();

        // Спојување на сите модули во една низа без дупликати
        return array_unique(array_merge($directModules, $groupModules));
    }

}
