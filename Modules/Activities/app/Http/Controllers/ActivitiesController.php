<?php

namespace Modules\Activities\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Activities;
use Illuminate\Http\Request;
use Modules\Activities\Dto\ActivitiesDto;
use Modules\Activities\Http\Requests\ActivitiesStoreRequest;
use Modules\Activities\Http\Requests\ActivitiesUpdateRequest;
use Modules\Activities\Services\ActivitiesServices;

class ActivitiesController extends Controller
{
    public function __construct(public ActivitiesServices $activitiesServices, private readonly ActivitiesDto $activitiesDto)
    {
    }
    public function index(Request $request): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
    {
        $return = $this->activitiesServices->index($request->all());
        return view('Activities::activities/index', $return['data']);
    }
    public function show($lang, $id_module, $id): \Illuminate\Foundation\Application|\Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
    {
        $return = $this->activitiesServices->show( $id);
        return view('Activities::activities/show', $return['data']);
    }

    public function create(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
    {

        return view('Activities::activities/edit');
    }

    public function store(ActivitiesStoreRequest $request): \Illuminate\Foundation\Application|\Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
    {
        $url_return= $request->get('url_return') ;
        $query= $request->get('query') ;
        $message_error= $request->get('message_error') ;
        $message_success= $request->get('message_success') ;

        $activitiesDto = $this->activitiesDto->fromRequest($request);
        $return = $this->activitiesServices->store($activitiesDto);

        if($return->status=='error'){
            return redirect(url($url_return).'?'.$query)->with('error', [$message_error, $return->method, $return->class]);
        }
        return redirect(url($url_return.'/'.$return->data['id']).'?'.$query)->with('success', $message_success);
    }

    public function edit($lang, $id_module, $id): \Illuminate\Foundation\Application|\Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
    {
        $return = $this->activitiesServices->edit($id);
        return view('Activities::activities/edit', $return['data']);
    }

    public function update(ActivitiesUpdateRequest $request, $id): \Illuminate\Foundation\Application|\Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
    {
        $url_return= $request->get('url_return') ;
        $query= $request->get('query') ;
        $message_error= $request->get('message_error') ;
        $message_success= $request->get('message_success') ;

        $activitiesDto = $this->activitiesDto->fromRequest($request);
        $return = $this->activitiesServices->update($activitiesDto);

        if($return->status=='error'){
            return redirect(url($url_return).'?'.$query)->with('error', [$message_error, $return->method, $return->class]);
        }
        return redirect(url($url_return).'?'.$query)->with('success', $message_success);
    }

    public function destroy($lang, $id_module, $id, Request $request): \Illuminate\Foundation\Application|\Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
    {
        $url_return= $request->get('url_return_war') ;
        $query= $request->get('query_war') ;
        $message_error= $request->get('error_war') ;
        $message_success= $request->get('success_war') ;

        $return = $this->activitiesServices->deleteActivity($id);

        $error = ($return->status == 'error' && !empty($return->data['error_message']))
            ? $return->data['error_message']
            : $message_error;

        $success = ($return->status == 'error' && !empty($return->data['success_message']))
            ? $return->data['success_message']
            : $message_success;

        if($return->status=='error'){
            return redirect(url($url_return).'?'.$query)->with('error', [$error, $return->method, $return->class]);
        }
        return redirect(url($url_return).'?'.$query)->with('success', $success);
    }
}
