<?php

namespace Modules\Countries\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Countries\Dto\CountriesDto;
use Modules\Countries\Http\Requests\CountriesStoreRequest;
use Modules\Countries\Http\Requests\CountriesUpdateRequest;
use Modules\Countries\Services\CountriesServices;

class CountriesController extends Controller
{
    public function __construct(public CountriesServices $countriesServices, private readonly CountriesDto $countriesDto)
    {
    }
    public function index(Request $request): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
    {
        $return = $this->countriesServices->index($request->all());
        return view('Countries::countries/index', $return['data']);
    }
    public function show($lang, $id_module, $id): \Illuminate\Foundation\Application|\Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
    {
        $return = $this->countriesServices->show( $id);
        return view('Countries::countries/show', $return['data']);
    }

    public function create(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
    {

        return view('Countries::countries/edit');
    }

    public function store(CountriesStoreRequest $request): \Illuminate\Foundation\Application|\Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
    {
        $url_return= $request->get('url_return') ;
        $query= $request->get('query') ;
        $message_error= $request->get('message_error') ;
        $message_success= $request->get('message_success') ;

        $countriesDto = $this->countriesDto->fromRequest($request);
        $return = $this->countriesServices->store($countriesDto);

        if($return->status=='error'){
            return redirect(url($url_return).'?'.$query)->with('error', [$message_error, $return->method, $return->class]);
        }
        return redirect(url($url_return.'/'.$return->data['id']).'?'.$query)->with('success', $message_success);
    }

    public function edit($lang, $id_module, $id): \Illuminate\Foundation\Application|\Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
    {
        $return = $this->countriesServices->edit($id);
        return view('Countries::countries/edit', $return['data']);
    }

    public function update(CountriesUpdateRequest $request, $id): \Illuminate\Foundation\Application|\Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
    {
        $url_return= $request->get('url_return') ;
        $query= $request->get('query') ;
        $message_error= $request->get('message_error') ;
        $message_success= $request->get('message_success') ;

        $countriesDto = $this->countriesDto->fromRequest($request);
        $return = $this->countriesServices->update($countriesDto);

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

        $return = $this->countriesServices->deleteCountry($id);

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
