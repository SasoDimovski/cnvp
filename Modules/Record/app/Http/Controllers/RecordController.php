<?php

namespace Modules\Record\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Record\Dto\RecordDto;
use Modules\Record\Http\Requests\RecordUpdateRequest;
use Modules\Record\Services\RecordServices;

class RecordController extends Controller
{
    public function __construct(public RecordServices $recordServices, private readonly RecordDto $recordDto)
    {
    }
    public function edit($lang, $id_module, $id): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
    {
        $record = $this->recordServices->getRecordById($id);
        $documents = $this->recordServices->getDocumentByIdRecordIdModule($id, $id_module);
        return view('Record::record/edit', compact('record','documents'));
    }
    public function update($lang, $id_module, $id, RecordUpdateRequest $request): \Illuminate\Foundation\Application|\Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
    {

        $url_return= $request->get('url_return') ;
        $query= $request->get('query') ;
        $message_error= $request->get('message_error') ;
        $message_success= $request->get('message_success') ;

        $recordDto = $this->recordDto->fromRequest($request);
        $return = $this->recordServices->update($id, $request->get('file_name_hidden'), $recordDto);

        if($return->status=='error'){
            return redirect(url($url_return).'?'.$query)->with('error', [$message_error, $return->method, $return->class]);
        }
        return redirect(url($url_return).'?'.$query)->with('success', $message_success);
    }




    public function storeDoc($lang, $id_module, $id_record, Request $request): \Illuminate\Foundation\Application|\Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
    {
        $url_return= $request->get('url_return_doc') ;
        $query= $request->get('query_doc') ;
        $message_error= $request->get('error_doc') ;
        $message_success= $request->get('success_doc') ;

        $data=$request->all();
        $return = $this->recordServices->storeDoc($id_record , $data);

        if($return->status=='error'){
            return redirect(url($url_return).'?'.$query)->with('error', [$message_error, $return->method, $return->class]);
        }
        return redirect(url($url_return).'?'.$query)->with('success', $message_success);
    }
    public function updateDoc($lang, $id_module, $id_record, $id_doc, Request $request): \Illuminate\Foundation\Application|\Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
    {
        $url_return= $request->get('url_return_doc') ;
        $query= $request->get('query_doc') ;
        $message_error= $request->get('error_doc') ;
        $message_success= $request->get('success_doc') ;

        $data=$request->all();
        $return = $this->recordServices->updateDoc( $id_record , $id_doc,  $data);

        if($return->status=='error'){
            return redirect(url($url_return).'?'.$query)->with('error', [$message_error, $return->method, $return->class]);
        }
        return redirect(url($url_return).'?'.$query)->with('success', $message_success);
    }

    public function deleteDoc($lang, $id_module, $id, $id_doc, Request $request): \Illuminate\Foundation\Application|\Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
    {
        $url_return= $request->get('url_return_doc') ;
        $query= $request->get('query_doc') ;
        $message_error= $request->get('error_doc') ;
        $message_success= $request->get('success_doc') ;

        $return = $this->recordServices->deleteDocument($id, $id_doc);

        if($return->status=='error'){
            return redirect(url($url_return).'?'.$query)->with('error', [$message_error, $return->method, $return->class]);
        }
        return redirect(url($url_return).'?'.$query)->with('success', $message_success);
    }

    public function showDoc($lang, $id_module, $id, $id_doc): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
    {
        $return = $this->recordServices->showDoc($id_doc);

        return view('Record::record/show-doc', $return['data']);
    }


    public function browser(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
    {
        return view('/admin/_browser');
    }
}
