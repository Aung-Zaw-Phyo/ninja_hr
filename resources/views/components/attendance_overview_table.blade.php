<div class="table-responsive">
    <table class="table table-bordered">
        <thead>
            <th>Employee</th>
            @foreach ($periods as $period)
            <th>{{ $period->format('d') }}</th>
            @endforeach
        </thead>
        <tbody>
            @foreach ($employees as $employee)
                <tr>
                    <td>{{ $employee->name }}</td>
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
                                $checkinIcon = '<i class="fa-solid fa-circle-check text-info"></i>';
                            }else if ($attendance->checkin_time > $office_start_time && $attendance->checkin_time < $break_start_time) {
                                $checkinIcon = '<i class="fa-solid fa-circle-check text-warning"></i>';
                            }else {
                                $checkinIcon = '<i class="fa-solid fa-circle-xmark text-danger"></i>';
                            }

                            if($attendance->checkout_time < $break_end_time) {
                                $checkoutIcon = '<i class="fa-solid fa-circle-xmark text-danger"></i>';
                            }else if ($attendance->checkout_time > $break_end_time && $attendance->checkout_time < $office_end_time ) {
                                $checkoutIcon = '<i class="fa-solid fa-circle-check text-warning"></i>';
                            }else {
                                $checkoutIcon = '<i class="fa-solid fa-circle-check text-info"></i>';
                            }
                        }
                    @endphp
                    <td>
                        <div>{!! $checkinIcon !!}</div>
                        <div>{!! $checkoutIcon !!}</div>
                    </td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
</div>