<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('reports.type_detail') }}</title>

    <style>

        @page {
            size: A4 landscape;
          /*  margin: 20px;*/
            margin-top: 120px;
        }

        @font-face {
            font-family: 'DejaVu Sans';
        }

        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 10px;
        }
        .title {
            text-align: center;
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            /*border: 1px solid black;*/
            margin-top: 10px;
        }

        th, td {
            border: 1px solid black;
            padding: 6px;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        tr {
            /*border: 1px solid black;*/
        }

        .text-left {
            text-align: left;
        }

        .total-row {
            font-weight: bold;
            background-color: #f2f2f2;
        }
        .desc {
            margin: 15px auto;
            /*border: 1px solid #ddd;*/
            /*padding: 15px;*/
            /*border-radius: 5px;*/
            /*background: #f9f9f9;*/
        }

        .header {
            margin-left: 5px;
        }
        .header_sub {
            color: #a8a8a8;
            margin-left: 10px;
        }
        .footer_sub {
            color: #a8a8a8;
            margin-left: 10px;
        }
        .title_report {
            text-transform: uppercase;
            font-weight: bold;
            margin-left: 10px;
            margin-bottom: 5px;
        }
        .line {
            height: 1px;
            background-color: #a8a8a8;
            margin: 7px;
        }
        .row {
            display: flex; /* Gi postavuva row_left i row_right eden do drug */
            /*border-bottom: 1px solid #ddd;*/
            padding: 1px 0;
            margin-left: 10px;
            align-items: center;
        }
        .row_left {
            float: left;
            width: auto;
            font-weight: bold;
            padding-right: 5px;

        }
        .row_right {

            font-weight: bold;
            width: auto;

        }

        .desc_f {
            margin: 15px auto;
            /*border: 1px solid #ddd;*/
            /*padding: 15px;*/
            /*border-radius: 5px;*/
            /*background: #f9f9f9;*/
        }
        .row_f {
            display: flex; /* Gi postavuva row_left i row_right eden do drug */
            /*border-bottom: 1px solid #ddd;*/
            padding: 1px 0;
            margin-left: 10px;
            /*align-items: center;*/
        }
        .row_left_f {
            float: left;
            width:60%;
            font-weight: bold;
            padding-right: 5px;
            text-align: right;

        }
        .row_right_f {

            font-weight: bold;
            width: auto;
            padding-right: 5px;

        }
        .gray {

           color: #a8a8a8;
        }
        .red {

            color: #b70000;
        }
        .orange {

            color: #e87d06;
        }

        header{
            position: fixed;
            left: 0px;
            right: 0px;
            height: 150px;
            margin-top: -90px;
        }
        footer{
            position: fixed;
            left: 0px;
            right: 0px;
            height: 150px;
            bottom: 0px;
            margin-bottom: -150px;
        }
    </style>
    <script type="text/php">
        if ( isset($pdf) ) {
            $font = Font_Metrics::get_font("helvetica", "bold");
            $pdf->page_text(72, 18, "Header: {PAGE_NUM} of {PAGE_COUNT}", $font, 6, array(0,0,0));
        }
    </script>
</head>
<body>
<header>
    <div class="header">
        <img src="{{ public_path('/uploads/_images/cnvp_logo_small.png')}}" />
    </div>

    <div class="header_sub">{{config('app.URL')}}</div>

    <div class="line"></div>
</header>
<footer>
    <div class="line"></div>
    <div class="footer_sub">{{config('app.URL')}}</div>

</footer>

<main>

<div class="desc">
    <div class="title_report">{{__('reports.title_report_detail')}}</div>

    <div class="row">
        <div class="row_left">
            {{__('reports.id_user')}}:
        </div>
        <div class="row_right orange">
            @foreach($users as $user)
                {{$user->name}}  {{$user->surname}}
            @endforeach
        </div>
    </div>


    <div class="row">
        <div class="row_left">
            {{__('reports.period')}}:
        </div>
        <div class="row_right orange">
            {{ $date1 }} - {{ $date2 }}
        </div>
    </div>

    @php
        $monthNumber = request()->query('month');
        $months = [
            1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April',
            5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August',
            9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December'
        ];
    @endphp

    @if($monthNumber)
        <div class="row">
            <div class="row_left red">
                {{__('reports.period_month')}}:
            </div>
            <div class="row_right orange">
                {{ $months[$monthNumber]}}
            </div>
        </div>
    @endif

    <div class="row"><strong>{{__('reports.projects')}}:</strong></div>
    @foreach($projects as $project)
    <div class="row">
        <strong class="gray">
            <span class="orange">{{$project->name}}</span>  ({{$project->description}})

        </strong>
    </div>
    @endforeach


</div>


<table>
    <thead>
    <tr>

        <th>{{ __('reports.id_user') }}</th>
		<th>{{ __('reports.year') }}</th>--}}
        <th>{{ __('reports.id_country') }}</th>
        <th>{{ __('reports.project') }}</th>
        <th>{{ __('reports.assignment') }}</th>
        <th>{{ __('reports.activity') }}</th>
        <th>{{ __('reports.duration_s') }}</th>
        <th>{{ __('reports.date') }}</th>
{{--        <th></th>--}}
{{--        <th>{{ __('reports.approved') }}</th>--}}
    </tr>
    </thead>
    <tbody>
    @php $total = 0; @endphp
    @foreach($records as $record)
        @php
            $total += $record->duration;
            $record_assignments_name = $record->assignments->name ?? 'n/a';
            $record_activities_name = $record->activities->name ?? 'n/a';
        @endphp
        <tr  @if($record->activities->type==1) style="color: #BD362F" @endif >

            <td>{{ $record->insertedByUser->name }} {{ $record->insertedByUser->surname }}</td>
            <td>{{ $record->year }}</td>--}}
            <td>{{ $record->countries->name }}</td>
            <td>{{ $record->projects->name }}</td>
            <td>{{ $record_assignments_name }}</td>
            <td>{{ $record_activities_name }}</td>
            <td>{{ $record->duration }}</td>
            <td>{{ date("d.m.Y", strtotime($record->date)) }}</td>
{{--            <td>--}}
{{--                @if($record->lockrecord == 1)--}}
{{--                    <i class="fas fa-lock locked-icon" title="{{ __('reports.locked_record') }}"></i>--}}
{{--                @endif--}}
{{--            </td>--}}
{{--            <td>--}}
{{--                @if($record->approvedby)--}}
{{--                    {{ $record->approvedByUser->name }} {{ $record->approvedByUser->surname }}--}}
{{--                    <i class="fas fa-check approved-icon" title="{{ __('records.approved') }}: {{ $record->approvedByUser->name }} {{ $record->approvedByUser->surname }}, ID: {{ $record->approvedByUser->id }}"></i>--}}
{{--                @endif--}}
{{--            </td>--}}
        </tr>
    @endforeach
    <tr class="total-row">
        <td colspan="6"  style="text-align: right;"><strong>{{ __('reports.total') }}:</strong></td>
        <td>{{ $total }}</td>
 <td colspan="1"></td>
    </tr>
    </tbody>
</table>


<div class="desc_f">

    <div class="row_f">
        <div class="row_left_f">
       {{__('reports.total_hours')}}:
        </div>
        <div class="row_right_f">
            {{ $total }}
        </div>
    </div>


    @php $total_non_working = 0; @endphp
    @foreach($activities as $activity)
        @php
            $total_non_working += $activityDurations[$activity->id] ?? 0;
        @endphp
    <div class="row_f">
        <div class="row_left_f gray">
            {{__('reports.total')}}   {{ $activity->name }}:
        </div>
        <div class="row_right_f gray">
            {{ $activityDurations[$activity->id] ?? 0 }}
        </div>
    </div>
    @endforeach

    <div class="row_f">
        <div class="row_left_f">
            {{__('reports.total_working_hours')}}:
        </div>
        <div class="row_right_f ">
            {{ $total-$total_non_working }}
        </div>
    </div>

    <div class="line"></div>

    <div class="row_f">
        <div class="row_left_f">
            {{__('reports.total_working_hours_for_all_projects')}}:
        </div>
        <div class="row_right_f ">
            {{ $totalDurationWithoutProjectFilter }}
        </div>
    </div>
    @foreach($projects as $project)
        @if(($projectDurations[$project->id]?? 0) >0)
        <div class="row_f">
            <div class="row_left_f gray">
                {{__('reports.total_working_hours_on')}} <span class="orange">{{ $project->name }}</span>:
            </div>
            <div class="row_right_f gray" style="float: left">
                {{ $projectDurations[$project->id] ?? 0 }}
            </div>
            <div class="row_right_f red">
                ({{ number_format(($projectDurations[$project->id] ?? 0) / ($totalDurationWithoutProjectFilter) * 100, 2) }} %)
            </div>
        </div>
        @endif
    @endforeach

</div>



<div class="line"></div>


<div class="desc">


    <div class="row">
        <div class="row_left">
            {{__('reports.submitted_by')}}:
        </div>
        <div class="row_right gray" style="margin-right: 20px;float: left">
{{--            {{ Auth::user()->name }} {{ Auth::user()->surname }}--}}
            {{$user->name}}  {{$user->surname}}
        </div>

        <div class="row_left">
            {{__('reports.approved_by')}}: ____________________________________________
        </div>
{{--        <div class="row_right_f gray">--}}
{{--            @foreach($approvedUsers as $index => $user)--}}
{{--                {{ $user->name }} {{ $user->surname }}@if(!$loop->last), @endif--}}
{{--            @endforeach--}}
{{--        </div>--}}
{{--        @if($approvalStatus==0)--}}
{{--        <div class="row_right red">--}}
{{--            {!! __('reports.approved_by_warning')!!}--}}
{{--        </div>--}}
{{--        @elseif($approvalStatus==2)--}}
{{--            <div class="row_right red">--}}
{{--                {!! __('reports.approved_by_warning_no_records')!!}--}}
{{--            </div>--}}
{{--        @endif--}}


    </div>

</div>


</main>
</body>
</html>
