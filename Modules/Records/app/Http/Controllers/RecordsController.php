<?php

namespace Modules\Records\Http\Controllers;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Modules\Records\Http\Requests\RecordsStoreDayRequest;
use Modules\Records\Http\Requests\RecordsStoreRequest;
use Modules\Records\Http\Requests\RecordsStoreTableRequest;
use Modules\Records\Http\Requests\RecordsStoreWeekRequest;
use Modules\Records\Services\RecordsServices;

class RecordsController extends Controller
{
    public function __construct(public RecordsServices $recordsServices)
    {
    }

    public function index($lang, $id_module, $id_user, Request $request): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
    {
        $return = $this->recordsServices->index($id_user,$request->all());
        return view('Records::records/index', $return['data']);
    }
    public function refreshIndex($lang, $id_module, $id_user, Request $request): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
    {
        $return = $this->recordsServices->refreshIndex($id_user,$request->all());
        return view('Records::records/_index', $return['data']);
    }
    public function editRecordDay($lang, $id_module, $date, $id_country, $id_user): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
    {

        $return = $this->recordsServices->editRecordDay($date,$id_country,$id_user);
        return view('Records::records/edit-records-day', $return['data']);
    }

    public function storeRecordDay(RecordsStoreDayRequest $request): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
    {
        $return = $this->recordsServices->storeRecordDay($request->all());

//        return redirect(url('admin/mk/14/records'));
        return view('Records::records/_records-day', $return['data']);
    }
    public function updateRecordDay($lang, $id_module, $id_record, Request $request): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
    {
        $return = $this->recordsServices->updateRecordDay($id_record,$request->all());
        //return redirect(url('admin/mk/14/records'));
        return view('Records::records/_records-day', $return['data']);

    }
    public function showRecordsDay($lang, $id_module, $date, $id_country, $id_user): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
    {
        $return = $this->recordsServices->showRecordsDay($date,$id_country,$id_user);
        return view('Records::records/show-records-box', $return['data']);
    }
    public function showRecordsDayList($lang, $id_module, $date, $id_country, $id_user): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
    {
        $return = $this->recordsServices->showRecordsDay($date,$id_country,$id_user);
        return view('Records::records/show-records-list', $return['data']);
    }
    public function deleteRecordsDay($lang, $id_module, $date, $id_country, $id_user, Request $request): \Illuminate\Foundation\Application|\Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
    {

        $url_return= $request->get('url_return_war') ;
        $query= $request->get('query_war') ;
        $message_error= $request->get('error_war') ;
        $message_success= $request->get('success_war') ;

        $return = $this->recordsServices->deleteRecordsDay($date, $id_country, $id_user);

        if($return->status=='error'){
            return redirect(url($url_return).'?'.$query)->with('error', [$return->data['error_message']]);
        }
        return redirect(url($url_return).'?'.$query)->with('success', $message_success);
    }

    public function editRecordsWeek($lang, $id_module, $date, $id_country, $id_user): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
    {

        $return = $this->recordsServices->editRecordsWeek($date,$id_country,$id_user);
        return view('Records::records/edit-records-week', $return['data']);
    }

    public function storeRecordsWeek(RecordsStoreWeekRequest $request): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
    {
        //dd($request);
        $return = $this->recordsServices->storeRecordsWeek($request->all());

       // return redirect(url('admin/mk/14/records'));
       return view('Records::records/_records-week', $return['data']);


    }
    public function updateRecordsWeek($lang, $id_module,Request $request): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
    {
        //dd($request->all());
        $return = $this->recordsServices->updateRecordsWeek($request->all());

        //return redirect(url('admin/mk/14/records'));
        return view('Records::records/_records-week', $return['data']);


    }
    public function showRecordsWeek($lang, $id_module, $date, $id_country, $id_user): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
    {
        $return = $this->recordsServices->showRecordsWeek($date,$id_country,$id_user);

        return view('Records::records/show-records-box', $return['data']);
    }
    public function showRecordsWeekList($lang, $id_module, $date, $id_country, $id_user): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
    {
        $return = $this->recordsServices->showRecordsWeek($date,$id_country,$id_user);
        //dd($return['data']);
        return view('Records::records/show-records-list', $return['data']);
    }
    public function deleteRecordsWeek($lang, $id_module, $date, $id_country, $id_user, Request $request): \Illuminate\Foundation\Application|\Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
    {
        $url_return= $request->get('url_return_war') ;
        $query= $request->get('query_war') ;
        $message_error= $request->get('error_war') ;
        $message_success= $request->get('success_war') ;

        $return = $this->recordsServices->deleteRecordsWeek($date, $id_country, $id_user);

        if($return->status=='error'){
            return redirect(url($url_return).'?'.$query)->with('error', [$return->data['error_message']]);
        }
        return redirect(url($url_return).'?'.$query)->with('success', $message_success);
    }

    public function indexRecordsTable($lang, $id_module, $id_user, Request $request): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
    {
        $return = $this->recordsServices->indexRecordsTable($id_user,$request->all() );
        return view('Records::records/index-records-table', $return['data']);
    }
    public function createRecordTable($lang, $id_module,$year,$id_user): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
    {
        $return = $this->recordsServices->createRecordTable($year,$id_user);
        return view('Records::records/edit-record-table', $return['data']);
    }
    public function storeRecordTable($lang, $id_module, $id_user, RecordsStoreTableRequest $request): \Illuminate\Foundation\Application|\Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
    {
        $url_return= $request->get('url_return') ;
        $query= $request->get('query') ;
        $message_error= $request->get('message_error') ;
        $message_success= $request->get('message_success') ;

        $month = Carbon::createFromFormat('d.m.Y', $request->get('date_'))->format('m');
        $query='id_country='.$request->get('id_country').'&year='.$request->get('year_temp').'&month='.$month;
        $return = $this->recordsServices->storeRecordTable($request->all());

        if($return->status=='error'){
            return redirect(url($url_return).'?'.$query)->with('error', [$message_error, $return->method, $return->class]);
        }
        return redirect(url($url_return).'?'.$query)->with('success', $message_success);
    }
    public function editRecordTable($lang, $id_module, $year, $id_record, $id_user): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
    {
        $return = $this->recordsServices->editRecordTable($year, $id_record, $id_user);
        return view('Records::records/edit-record-table', $return['data']);
    }
    public function updateRecordTable($lang, $id_module, $id_record, $id_user, Request $request): \Illuminate\Foundation\Application|\Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
    {
        $url_return= $request->get('url_return') ;
        $query= $request->get('query') ;
        $message_error= $request->get('message_error') ;
        $message_success= $request->get('message_success') ;

        $month = Carbon::createFromFormat('d.m.Y', $request->get('date_'))->format('m');
        $query='id_country='.$request->get('id_country').'&year='.$request->get('year_temp').'&month='.$month;
        $return = $this->recordsServices->updateRecordTable($id_record,$request->all());

        if($return->status=='error'){
            return redirect(url($url_return).'?'.$query)->with('error', [$message_error, $return->method, $return->class]);
        }
        return redirect(url($url_return).'?'.$query)->with('success', $message_success);

    }
    public function deleteRecordTable($lang, $id_module, $id_record, $id_user, Request $request): \Illuminate\Foundation\Application|\Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
    {

        $url_return= $request->get('url_return_war') ;
        $query= $request->get('query_war') ;
        $message_error= $request->get('error_war') ;
        $message_success= $request->get('success_war') ;
        $return = $this->recordsServices->deleteRecordTable($id_record);

        if($return->status=='error'){
            return redirect(url($url_return).'?'.$query)->with('error', [$message_error, $return->method, $return->class]);
        }
        return redirect(url($url_return).'?'.$query)->with('success', $message_success);
    }
    public function showRecordTable($lang, $id_module, $id_record, $id): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
    {
        $return = $this->recordsServices->showRecordTable($id_record);
        return view('Records::records/show-record-table', $return['data']);
    }



    public function getActivities($lang, $id_module, $id_project, $id_user): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
    {
        $return= $this->recordsServices->getActivities($id_project);

        return view('Records::records/_activities', $return['data']);
    }
    public function getAssignments($lang, $id_module, $id_project, $id_user): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
    {
        $return= $this->recordsServices->getAssignments($id_project);

        return view('Records::records/_assignments', $return['data']);
    }
}

