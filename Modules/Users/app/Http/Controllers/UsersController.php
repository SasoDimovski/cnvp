<?php

namespace Modules\Users\Http\Controllers;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Modules\Users\Dto\UsersDto;
use Modules\Users\Http\Requests\UsersUpdateRequest;
use Modules\Users\Services\UsersServices;


class UsersController extends Controller
{
    public function __construct(public UsersServices $usersServices, private readonly UsersDto $usersDto)
    {
    }

    public function index($lang, $id_module, Request $request): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
    {
        $return = $this->usersServices->index($lang,$request->all());
        return view('Users::users/index', $return['data']);
    }

    public function create(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
    {
        $return = $this->usersServices->create();
        return view('Users::users/edit', $return['data']);
    }

    public function store(UsersUpdateRequest $request): \Illuminate\Foundation\Application|\Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
    {
        $url_return= $request->get('url_return') ;
        $query= $request->get('query') ;
        $message_error= $request->get('message_error') ;
        $message_success= $request->get('message_success') ;

        $usersDto = $this->usersDto->fromRequest($request);
        $return = $this->usersServices->store($request->get('id_country'),$usersDto);

        if($return->status=='error'){
            return redirect(url($url_return).'?'.$query)->with('error', [$message_error, $return->method, $return->class]);
        }
        return redirect(url($url_return.'/'.$return->data['id']).'?'.$query)->with('success', $message_success);

    }

    public function edit($lang, $id_module, $id): \Illuminate\Foundation\Application|\Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
    {
        $return = $this->usersServices->edit($lang, $id);
        return view('Users::users/edit', $return['data']);
    }

    public function update(UsersUpdateRequest $request): \Illuminate\Foundation\Application|\Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
    {
        $url_return= $request->get('url_return') ;
        $query= $request->get('query') ;
        $message_error= $request->get('message_error') ;
        $message_success= $request->get('message_success') ;
        $usersDto = $this->usersDto->fromRequest($request);
        $return = $this->usersServices->update($request->get('id_country'),$request->get('file_name_hidden'), $usersDto);

        if($return->status=='error'){
            return redirect(url($url_return).'?'.$query)->with('error', [$message_error, $return->method, $return->class]);
        }
        return redirect(url($url_return).'?'.$query)->with('success', $return->data['message_success']);
    }

    public function show($lang, $id_module, $id): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
    {
        $return = $this->usersServices->show($id);
        return view('Users::users/show', $return['data']);
    }

    public function destroy($lang, $id_module, $id, Request $request): \Illuminate\Foundation\Application|\Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
    {
        $url_return= $request->get('url_return_war') ;
        $query= $request->get('query_war') ;
        $message_error= $request->get('error_war') ;
        $message_success= $request->get('success_war') ;
        $return = $this->usersServices->deleteUser($id);

        if($return->status=='error'){
            return redirect(url($url_return).'?'.$query)->with('error', [$message_error, $return->method, $return->class]);
        }
        return redirect(url($url_return).'?'.$query)->with('success', $message_success);
    }
    public function sendEmailReg($lang, $id_module, $id, Request $request): \Illuminate\Foundation\Application|\Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
    {
        $url_return= $request->get('url_return_war') ;
        $query= $request->get('query_war') ;
        $message_error= $request->get('error_war') ;
        $message_success= $request->get('success_war') ;
        $return = $this->usersServices->sendEmailReg($id);
        if($return->status=='error'){
            return redirect(url($url_return).'?'.$query)->with('error', [$message_error, $return->method, $return->class]);
        }
        return redirect(url($url_return).'?'.$query)->with('success', $message_success);
    }



    public function indexRecords($lang, $id_module, $id, Request $request): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
    {
        $return = $this->usersServices->indexRecords($id,$request->all() );
        return view('Users::users/index-records', $return['data']);
    }
    public function createRecord($lang, $id_module,$year, $id_user): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
    {
        $return = $this->usersServices->createRecord($year,$id_user);
        //dd($return);

        return view('Users::users/edit-record', $return['data']);
    }
    public function storeRecord($lang, $id_module, $id_user, Request $request): \Illuminate\Foundation\Application|\Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
    {
        $url_return= $request->get('url_return') ;
        $query= $request->get('query') ;
        $message_error= $request->get('message_error') ;
        $message_success= $request->get('message_success') ;

        $month = Carbon::createFromFormat('d.m.Y', $request->get('date_'))->format('m');
        $query='id_country='.$request->get('id_country').'&year='.$request->get('year_temp').'&month='.$month;
        $return = $this->usersServices->storeRecord($request->all());

        if($return->status=='error'){
            return redirect(url($url_return).'?'.$query)->with('error', [$message_error, $return->method, $return->class]);
        }
        return redirect(url($url_return).'?'.$query)->with('success', $message_success);

    }
    public function editRecord($lang, $id_module,$year,  $id_record, $id_user): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
    {
        $return = $this->usersServices->editRecord($year, $id_record, $id_user);
        //dd($return);

        return view('Users::users/edit-record', $return['data']);
    }
    public function updateRecord($lang, $id_module, $id_record, $id_user, Request $request): \Illuminate\Foundation\Application|\Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
    {

        $url_return= $request->get('url_return') ;
        $query= $request->get('query') ;
        $message_error= $request->get('message_error') ;
        $message_success= $request->get('message_success') ;

        $month = Carbon::createFromFormat('d.m.Y', $request->get('date_'))->format('m');
        $query='id_country='.$request->get('id_country').'&year='.$request->get('year_temp').'&month='.$month;

        $return = $this->usersServices->updateRecord($id_record,$request->all());

        if($return->status=='error'){
            return redirect(url($url_return).'?'.$query)->with('error', [$message_error, $return->method, $return->class]);
        }
        return redirect(url($url_return).'?'.$query)->with('success', $message_success);

    }
    public function showRecord($lang, $id_module, $id): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
    {
        $return = $this->usersServices->showRecord($id);
        return view('Users::users/show-record', $return['data']);
    }
    public function deleteRecord($lang, $id_module, $id_record, $id_user, Request $request): \Illuminate\Foundation\Application|\Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
    {

        $url_return= $request->get('url_return_war') ;
        $query= $request->get('query_war') ;
        $message_error= $request->get('error_war') ;
        $message_success= $request->get('success_war') ;
        $return = $this->usersServices->deleteRecord($id_record);

        if($return->status=='error'){
            return redirect(url($url_return).'?'.$query)->with('error', [$message_error, $return->method, $return->class]);
        }
        return redirect(url($url_return).'?'.$query)->with('success', $message_success);
    }


    public function getActivities($lang, $id_module, $id_project, $id_user): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
    {
        $return= $this->usersServices->getActivities($id_project);

        return view('Users::users/_activities', $return['data']);
    }
    public function getAssignments($lang, $id_module, $id_project, $id_user): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
    {
        $return= $this->usersServices->getAssignments($id_project);

        return view('Users::users/_assignments', $return['data']);
    }


    public function lockApproveRecords(Request $request): \Illuminate\Foundation\Application|\Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
    {
        $data=$request->all();
        $url_return= $request->get('url_return') ;
        $query= $request->get('query') ;
        $message_error= $request->get('message_error') ;
        $message_success= $request->get('message_success') ;

        $return = $this->usersServices->lockApproveRecords($data);

        if($return->status=='error'){
            return redirect(url($url_return).'?'.$query)->with('error', [$message_error, $return->method, $return->class]);
        }
        return redirect(url($url_return).'?'.$query)->with('success', $message_success);

    }



    public function addGroupToUser($lang, $id_module, $id_user, $id_group, Request $request): \Illuminate\Foundation\Application|\Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
    {
        $url_return= $request->get('url_return_war') ;
        $query= $request->get('query_war') ;
        $message_error= $request->get('error_war') ;
        $message_success= $request->get('success_war') ;

        $return = $this->usersServices->addGroupToUser($id_user, $id_group);

        if($return->status=='error'){
            return redirect(url($url_return).'?'.$query)->with('error', [$message_error, $return->method, $return->class]);
        }
        return redirect(url($url_return).'?'.$query)->with('success', $message_success);
    }
    public function removeGroupToUser($lang, $id_module, $id_user, $id_group, Request $request): \Illuminate\Foundation\Application|\Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
    {
        $url_return= $request->get('url_return_war') ;
        $query= $request->get('query_war') ;
        $message_error= $request->get('error_war') ;
        $message_success= $request->get('success_war') ;

        $return = $this->usersServices->removeGroupToUser($id_user, $id_group);

        if($return->status=='error'){
            return redirect(url($url_return).'?'.$query)->with('error', [$message_error, $return->method, $return->class]);
        }
        return redirect(url($url_return).'?'.$query)->with('success', $message_success);

    }

}
