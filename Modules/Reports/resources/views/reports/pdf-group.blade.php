<!DOCTYPE html>
<html lang="mk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('reports.type_group') }}</title>

    <style>
        @page {
            size: A4 landscape;
            margin: 20px;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
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

        .text-left {
            text-align: left;
        }

        .total-row {
            font-weight: bold;
            background-color: #f2f2f2;
        }

    </style>
</head>
<body>

<div class="title">
    <span>{{ __('reports.type_group') }}</span>
</div>

<table>
    <thead>
    <tr>
        <th>{{ __('reports.id_user') }}</th>
        <th>{{ __('reports.id_country') }}</th>
        <th>{{ __('reports.year') }}</th>
        <th>{{ __('reports.date') }}</th>
        <th>{{ __('reports.project') }}</th>
        <th>{{ __('reports.assignment') }}</th>
        <th>{{ __('reports.activity') }}</th>
        <th>{{ __('reports.duration_s') }}</th>
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
        <tr>
            <td>{{ $record->insertedByUser->name }} {{ $record->insertedByUser->surname }}</td>
            <td>{{ $record->countries->name }}</td>
            <td>{{ $record->year }}</td>
            <td>{{ $record->date}}</td>
            <td>{{ $record->projects->name }}</td>
            <td>{{ $record_assignments_name }}</td>
            <td>{{ $record_activities_name }}</td>
            <td>{{ $record->duration }}</td>
        </tr>
    @endforeach
    <tr class="total-row">
        <td colspan="7" class="text-right"><strong>{{ __('reports.total') }}:</strong></td>
        <td>{{ $total }}</td>
    </tr>
    </tbody>
</table>

</body>
</html>
