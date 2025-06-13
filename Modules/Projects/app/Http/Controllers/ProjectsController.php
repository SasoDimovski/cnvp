<?php

namespace Modules\Projects\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Projects\Dto\ProjectAssignmentsDto;
use Modules\Projects\Dto\ProjectsDto;
use Modules\Projects\Http\Requests\ProjectsAssignmentsStoreRequest;
use Modules\Projects\Http\Requests\ProjectsAssignmentsUpdateRequest;
use Modules\Projects\Http\Requests\ProjectsStoreRequest;
use Modules\Projects\Http\Requests\ProjectsUpdateRequest;
use Modules\Projects\Services\ProjectsServices;

class ProjectsController extends Controller
{
    public function __construct(public ProjectsServices $projectsServices, private readonly ProjectsDto $projectsDto, private readonly ProjectAssignmentsDto $assignmentsDto)
    {
    }

    public function index(Request $request): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
    {
        $return = $this->projectsServices->index($request->all());
        return view('Projects::projects/index', $return['data']);
    }

    public function create(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
    {
        $return = $this->projectsServices->create();
        return view('Projects::projects/edit', $return['data']);
    }

    public function store(ProjectsStoreRequest $request): \Illuminate\Foundation\Application|\Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
    {
        $url_return= $request->get('url_return') ;
        $query= $request->get('query') ;
        $message_error= $request->get('message_error') ;
        $message_success= $request->get('message_success') ;

        $projectsDto = $this->projectsDto->fromRequest($request);
        $return = $this->projectsServices->store($request->get('activities'),$projectsDto);

        if($return->status=='error'){
            return redirect(url($url_return).'?'.$query)->with('error', [$message_error, $return->method, $return->class]);
        }
        return redirect(url($url_return.'/'.$return->data['id']).'?'.$query)->with('success', $message_success);
    }

    public function show($lang, $id_module, $id): \Illuminate\Foundation\Application|\Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
    {
        $return = $this->projectsServices->show( $id);
        return view('Projects::projects/show', $return['data']);
    }

    public function edit($lang, $id_module, $id): \Illuminate\Foundation\Application|\Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
    {
        $return = $this->projectsServices->edit($id);
        return view('Projects::projects/edit', $return['data']);
    }

    public function update(ProjectsUpdateRequest $request, $id): \Illuminate\Foundation\Application|\Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
    {
        $url_return= $request->get('url_return') ;
        $query= $request->get('query') ;
        $message_error= $request->get('message_error') ;
        $message_success= $request->get('message_success') ;

        $projectsDto = $this->projectsDto->fromRequest($request);
        $return = $this->projectsServices->update($request->get('activities'),$projectsDto);

        if($return->status=='error'){
            return redirect(url($url_return).'?'.$query)->with('error', [$message_error, $return->method, $return->class]);
        }
        return redirect(url($url_return).'?'.$query)->with('success', $return->data['message_success']);
    }

    public function destroy($lang, $id_module, $id, Request $request): \Illuminate\Foundation\Application|\Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
    {
        $url_return= $request->get('url_return_war') ;
        $query= $request->get('query_war') ;
        $message_error= $request->get('error_war') ;
        $message_success= $request->get('success_war') ;

        $return = $this->projectsServices->deleteProject($id);

        if($return->status=='error'){
            return redirect(url($url_return).'?'.$query)->with('error', [$message_error, $return->method, $return->class]);
        }
        return redirect(url($url_return).'?'.$query)->with('success', $message_success);
    }

    public function showAssignment($lang, $id_module, $id): \Illuminate\Foundation\Application|\Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
    {
        $return = $this->projectsServices->showAssignment( $id);
        return view('Projects::projects/show-assign', $return['data']);
    }
    public function editAssignment($lang, $id_module, $id, $id_assign): \Illuminate\Foundation\Application|\Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
    {
        $return = $this->projectsServices->editAssignment($id_assign);
        return view('Projects::projects/edit-assign', $return['data']);
    }

    public function updateAssignment(ProjectsAssignmentsUpdateRequest $request, $id): \Illuminate\Foundation\Application|\Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
    {
        $url_return= $request->get('url_return') ;
        $query= $request->get('query') ;
        $message_error= $request->get('message_error') ;
        $message_success= $request->get('message_success') ;

        $assignmentsDto = $this->assignmentsDto->fromRequest($request);

        $return = $this->projectsServices->updateAssignment($assignmentsDto);

        if($return->status=='error'){
            return redirect(url($url_return).'?'.$query)->with('error', [$message_error, $return->method, $return->class]);
        }
        return redirect(url($url_return).'?'.$query)->with('success', $message_success);
    }

    public function createAssignment(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
    {
        return view('Projects::projects/edit-assign');
    }

    public function storeAssignment($lang, $id_module, $id, ProjectsAssignmentsStoreRequest $request): \Illuminate\Foundation\Application|\Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
    {
        $url_return= $request->get('url_return') ;
        $query= $request->get('query') ;
        $message_error= $request->get('message_error') ;
        $message_success= $request->get('message_success') ;

        $assignmentsDto = $this->assignmentsDto->fromRequest($request);
        $return = $this->projectsServices->storeAssignment($assignmentsDto,$id);

        if($return->status=='error'){
            return redirect(url($url_return).'?'.$query)->with('error', [$message_error, $return->method, $return->class]);
        }
        return redirect(url($url_return).'?'.$query)->with('success', $message_success);
    }
    public function deleteAssignment($lang, $id_module, $id, Request $request): \Illuminate\Foundation\Application|\Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
    {
        //dd($id);
        $url_return= $request->get('url_return_war') ;
        $query= $request->get('query_war') ;
        $message_error= $request->get('error_war') ;
        $message_success= $request->get('success_war') ;

        $return = $this->projectsServices->deleteAssignment($id);

        $error = ($return->status == 'error' && !empty($return->data['error_message']))
            ? $return->data['error_message']
            : $message_error;

        if($return->status=='error'){
            return redirect(url($url_return).'?'.$query)->with('error', [$error, $return->method, $return->class]);
        }
        return redirect(url($url_return).'?'.$query)->with('success', $message_success);
    }

}
