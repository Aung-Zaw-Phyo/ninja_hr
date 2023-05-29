<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Attendance</title>
    <style>
        body{
            font-size: 14px;
            font-family:Georgia, 'Times New Roman', Times, serif;
        }
        .table-bordered {
            border: 1px solid #dee2e6;
        }
        .table {
            width: 100%;
            margin-bottom: 1rem;
            color: #212529;
        }
        table {
            border-collapse: collapse;
        }
        thead {
            display: table-header-group;
            vertical-align: middle;
            border-color: inherit;
        }
        tr {
            display: table-row;
            vertical-align: inherit;
            /* border-color: inherit; */
        }
        .table-bordered thead td, .table-bordered thead th {
            border-bottom-width: 2px !important;
        }

        .table thead th {
            vertical-align: bottom;
            border-bottom: 2px solid #dee2e6 !important;
        }
        .table-bordered td, .table-bordered th {
            border: 1px solid #dee2e6 !important;
        }
        .table td, .table th {
            padding: 0.75rem;
        }
        .table-bordered td, .table-bordered th {
            border: 1px solid #dee2e6;
        }
        .text-center {
            text-align: center
        }

    </style>
</head>
<body>
    <div class="header">
        <h2>Attendance</h2>
    </div>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th class="text-center">Employee</th>
                <th class="text-center">Date</th>
                <th class="text-center">Checkin Time</th>
                <th class="text-center">Checkout Time</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($attendances as $attendance)
                <tr>
                    <td class="text-center">{{ optional($attendance->employee)->name }}</td>
                    <td class="text-center">{{ $attendance->date }}</td>
                    <td class="text-center">{{ $attendance->checkin_time }}</td>
                    <td class="text-center">{{ $attendance->checkout_time }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>