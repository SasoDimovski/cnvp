<?php

namespace Modules\Reports\Http\Controllers;

use App\Http\Controllers\Controller;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use Modules\Reports\Exports\ReportsExportExcelDetail;
use Modules\Reports\Exports\ReportsExportExcelGroup;
use Modules\Reports\Services\ReportsServices;

class ReportsController extends Controller
{
    public function __construct(public ReportsServices $reportsServices)
    {
    }
    public function index($lang, $id_module,  Request $request): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
    {
        //dd($lang);
        $type = $request['type'] ?? 1;
        $view = 'index-detail';
        //dd($request['type']);
        $return = $this->reportsServices->index($lang,$request->all());
       if ($type == 2) {
            $view = 'index-group';
        }
        return view('Reports::reports/'.$view, $return['data']);
    }
    public function exportExcelDetail(Request $request): \Symfony\Component\HttpFoundation\BinaryFileResponse
    {
        ini_set('memory_limit', '-1');
        set_time_limit(300);
        $records = $this->reportsServices->getAllRecordsExcel($request->all());
        $title = date('Ymd_His');
        //dd($records);

        return Excel::download(new ReportsExportExcelDetail($records), $title.'_detail_report.xlsx');
    }
    public function exportExcelGroup(Request $request): \Symfony\Component\HttpFoundation\BinaryFileResponse
    {
        ini_set('memory_limit', '-1');
        set_time_limit(300);
        $records = $this->reportsServices->getAllRecordsExcel($request->all());
        $title = date('Ymd_His');
        //dd($records);

        return Excel::download(new ReportsExportExcelGroup($records), $title.'_group_report.xlsx');
    }
    public function exportPdfDetail(Request $request)//: \Illuminate\Http\Response
    {
        ini_set('memory_limit', '-1'); // Оневозможува лимит
        set_time_limit(300);
        $recordsData = $this->reportsServices->getAllRecordsPdf($request->all());
        $records = $recordsData['records'];
        $users = $recordsData['users'];
        $projects = $recordsData['projects'];
        $date1 = $recordsData['date1'];
        $date2 = $recordsData['date2'];
        $activityDurations = $recordsData['activityDurations'];
        $activities = $recordsData['activities'];
        $projectDurations= $recordsData['projectDurations'];
        $approvedUsers= $recordsData['approvedUsers'];
        $approvalStatus= $recordsData['approvalStatus'];
        $totalDurationWithoutProjectFilter= $recordsData['totalDurationWithoutProjectFilter'];
        //dd($recordsData);



        $title = date('Ymd_His');

/* =====================================================================================================*/
        $pdf= PDF::loadView('Reports::reports.pdf-detail', [
            'records' => $records,
            'users' => $users,
            'projects' => $projects,
            'date1' => $date1,
            'date2' => $date2,
            'activityDurations' => $activityDurations,
            'activities' => $activities,
            'projectDurations' => $projectDurations,
            'approvedUsers' => $approvedUsers,
            'approvalStatus' => $approvalStatus,
            'totalDurationWithoutProjectFilter' => $totalDurationWithoutProjectFilter,
        ]) ->setPaper('a4', 'landscape')
            ->setOptions([
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => true,
                'chroot' => public_path()
            ]);

        //dd($pdf);
        //$pdf->getDomPDF()->setHttpContext($context);
        //return $pdf->stream($title . '.pdf');
        return $pdf->download($title . '_detail_report.pdf');

/* =====================================================================================================*/
//        return view('Reports::reports.pdf-detail', [
//            'records' => $records,
//            'users' => $users,
//            'projects' => $projects,
//            'date1' => $date1,
//            'date2' => $date2,
//            'activityDurations' => $activityDurations,
//            'activities' => $activities,
//            'projectDurations' => $projectDurations,
//            'approvedUsers' => $approvedUsers,
//            'approvalStatus' => $approvalStatus,
//            'totalDurationWithoutProjectFilter' => $totalDurationWithoutProjectFilter,
//
//        ]);



    }
    public function exportPdfGroup(Request $request): \Illuminate\Http\Response
    {
        $records = $this->reportsServices->getAllRecordsPdf($request->all());
        $title = date('Ymd_His');
        $pdf = Pdf::loadView('Reports::reports.pdf-group', ['records' => $records]) ->setPaper('a4', 'landscape');;
        //return $pdf->stream($title . '.pdf');
        return $pdf->download($title . '_detail_report.pdf');
        //return view('Reports::reports.pdf-group', ['records' => $records]);
    }
}
