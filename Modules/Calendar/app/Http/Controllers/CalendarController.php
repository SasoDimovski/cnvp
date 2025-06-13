<?php

namespace Modules\Calendar\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Calendar\Services\CalendarServices;

class CalendarController extends Controller
{
    public function __construct(public CalendarServices $calendarServices)
    {
    }

    public function index(Request $request): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
    {
        $return = $this->calendarServices->index($request->all());
        return view('Calendar::calendar/index', $return['data']);
    }


    public function newYear($lang, $id_module, $year, Request $request): \Illuminate\Foundation\Application|\Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
    {
        $id_country = $request->get('id_country');

        $url_return = $request->get('url_return_war');
        $query = $request->get('query_war');
        $message_error = $request->get('message_error_war');
        $message_success = $request->get('message_success_war');

        $return = $this->calendarServices->newYear($year, $id_country);

        if ($return->status == 'error') {
            return redirect(url($url_return) . '?' . $query)->with('error', $return->data['error_message']);
        }
        return redirect(url($url_return) . '?id_country=' . $return->data['id_country'] . '&year=' . $year)->with('success', $return->data['success_message']);
    }

    public function insertHolidays(Request $request): \Illuminate\Foundation\Application|\Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
    {
        $url_return = $request->get('url_return');
        $query = $request->get('query');
        $return = $this->calendarServices->insertHolidays($request->all());

        if ($return->status == 'error') {
            return redirect(url($url_return) . '?' . $query)->with('error', $return->data['error_message']);
        }
        return redirect(url($url_return) . '?' . $query)->with('success', $return->data['success_message']);
    }

    public function delete($lang, $id_module, $year, Request $request): \Illuminate\Foundation\Application|\Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
    {

        $url_return= $request->get('url_return_war') ;
        $query= $request->get('query_war') ;
        $message_error= $request->get('error_war') ;
        $message_success= $request->get('success_war') ;

        $return = $this->calendarServices->deleteYear($year);

        if($return->status=='error'){
            return redirect(url($url_return).'?'.$query)->with('error', [$return->data['error_message'], $return->method, $return->class]);
        }
        return redirect(url($url_return))->with('success', $return->data['success_message']);
    }
}

