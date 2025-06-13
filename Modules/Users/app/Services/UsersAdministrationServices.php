<?php

namespace Modules\Users\Services;

use App\Models\Modules;
use App\Models\Users;
use Illuminate\Support\Facades\Auth;
use Modules\Users\Repositories\UsersAdministrationRepositories;

class UsersAdministrationServices
{
    public function __construct(public UsersAdministrationRepositories $usersAdministrationRepositories)
    {
    }






    public function index($lang, Request $request,MainServices $mainServices): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
    {
        $lang = $request->route('lang');
        $id_language = $this->mainServices->getLanguagesByLang($lang)->id;
        $user = Auth::user();


        // Модули директно доделени на корисникот
        $userModules = $user->modules;
        // Модули преку групите на корисникот
        $groupModules = $user->groups->flatMap(function ($group) {
            return $group->modules;
        });
        // Комбинирај ги модули и отстрани дупликати
        //$users_modules = $userModules->merge($groupModules)->unique('id');
        //$users_modules= $user->modules;
        //dd(Auth::user()->id);

        //++++++++++++++++++++++++++++++++++++++++++++++++++
        //ДОДЕЛЕНИ МОДУЛИ
        $assignedModulesAll = $this->assignedModulesAll(Auth::id(),$id_language);
        //ДОДЕЛЕНИ МОДУЛИ ПРЕКУ МОДУЛИ
        $assignedModulesModules = $this->assignedModulesModules(Auth::id(),$id_language);
        //НЕДОДЕЛЕНИ МОДУЛИ ПРЕКУ МОДУЛИ
        $unassignedModulesModules = $this->unassignedModulesModules(Auth::id(),$id_language);



        //СИТЕ МОДУЛИ
        $modules = Modules::all()->filter(function ($module) use ($id_language) {
            return $module->active == 1
                && $module->deleted == 0
                && $module->id_language == $id_language
                && $module->id_modules_type == 1;
        })
            ->load('type', 'design')
            ->sortBy('created_at');
        $modules = $this->buildModuleTree($modules);



        // Пример за добивање на сите корисници од прв модул
        $moduleId = 1; // Замени со ID на модулот што го бараш
        $module = Modules::find($moduleId);
        if ($module) {
            $modules_users = $module->users; // Ги добива сите корисници на модулот
        } else {
            $modules_users = collect(); // Празна колекција ако модулот не постои
        }

        //ДОДЕЛЕНИ ГРУПИ
        $assignedGroups = $user->groups()->with('modules')->get();
        //НЕДОДЕЛЕНИ ГРУПИ
        $assignedGroupIds = $user->groups->pluck('id')->flatten()->toArray();
        $unassignedGroups = Groups::whereNotIn('id', $assignedGroupIds)->get();

        // СИТЕ ГРУПИ
        //$groups = Groups::all();
        $groups = Groups::with(['modules' => function ($query) use ($id_language) {
            $query->where('modules.active', 1) // Додадете префикс на табелата
            ->where('modules.deleted', 0)
                ->where('modules.id_language', $id_language)
                ->where('modules.id_modules_type', 1)
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
        return view('Main::main/index',compact('assignedModulesAll','assignedModulesModules','unassignedModulesModules', 'assignedGroups','unassignedGroups','modules','groups'));
    }







    public function addModuleToUser($id_user, $id_mod)
    {
        //dd($id_user);

        return redirect(url("admin/main"))->with('success', __('global.save_success'));

    }

    public function removeModuleToUser($lang, $id_module, $id_user, $id_mod)
    {

        return redirect(url("admin/{$lang}/main"))->with('success', __('global.save_success'));

    }

}
