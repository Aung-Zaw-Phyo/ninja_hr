<div class="table-responsive">
    <table class="table table-bordered table-striped">
        <thead>
            <th>Employee</th>
            <th class="text-center">Role</th>
            <th class="text-center">Days of Month</th>
            <th class="text-center">Working Days</th>
            <th class="text-center">Off Days</th>
            <th class="text-center">Attendance Day</th>
            <th class="text-center">Leave</th>
            <th class="text-center">Per Day (MMk)</th>
            <th class="text-center">Totoal (MMK)</th>
        </thead>
        <tbody>
            @foreach ($employees as $employee)
                @php
                    $attendance_days = 0;
                    $salary = collect($employee->salaries)->where('month', $month)->where('year', $year)->first();
                    $perDay = $salary ? $salary->amount / $working_days : 0;
                @endphp
                @foreach ($periods as $period)
                @php
                    $office_start_time = $period->format('Y-m-d') . ' ' . $company_setting->office_start_time;
                    $office_end_time = $period->format('Y-m-d') . ' ' . $company_setting->office_end_time;
                    $break_start_time = $period->format('Y-m-d') . ' ' . $company_setting->break_start_time;
                    $break_end_time = $period->format('Y-m-d') . ' ' . $company_setting->break_end_time;

                    $attendance = collect($attendances)->where('date', $period->format('Y-m-d'))->where('user_id', $employee->id)->first();    
                    $checkinIcon = '';
                    $checkoutIcon = '';
                    if($attendance) {
                        if ($attendance->checkin_time < $office_start_time) {
                            $attendance_days += 0.5;
                        }else if ($attendance->checkin_time > $office_start_time && $attendance->checkin_time < $break_start_time) {
                            $attendance_days += 0.5;
                        }else {
                            $attendance_days += 0;
                        }

                        if($attendance->checkout_time < $break_end_time) {
                            $attendance_days += 0;
                        }else if ($attendance->checkout_time > $break_end_time && $attendance->checkout_time < $office_end_time ) {
                            $attendance_days += 0.5;
                        }else {
                            $attendance_days += 0.5;
                        }
                    }
                @endphp
                @endforeach
                @php
                    $leave_days = $working_days - $attendance_days;
                    $total = $perDay * $attendance_days;
                @endphp
                <tr>
                    <td>{{ $employee->name }}</td>
                    <td class="text-center">{{ implode(', ',$employee->roles->pluck('name')->toArray()) }}</td>
                    <td class="text-center">{{ $daysInMonth }}</td>
                    <td class="text-center">{{ $working_days }}</td>
                    <td class="text-center">{{ $offDays }}</td>
                    <td class="text-center">{{ $attendance_days }}</td>
                    <td class="text-center">{{ $leave_days }}</td>
                    <td class="text-center">{{ number_format($perDay) }}</td>
                    <td class="text-center">{{ number_format($total) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>