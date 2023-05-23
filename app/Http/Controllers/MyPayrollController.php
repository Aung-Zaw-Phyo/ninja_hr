<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use App\Models\CheckinCheckout;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAttendance;
use App\Http\Requests\UpdateAttendance;
use App\Models\CompanySetting;
use Yajra\DataTables\Facades\DataTables;

class MyPayrollController extends Controller
{

    public function payrollTable (Request $request) {
        $month = $request->month;
        $year = $request->year;

        $startOfMonth = $year . '-' . $month . '-01' ; //2023-05-01
        $endOfMonth = Carbon::parse($startOfMonth)->endOfMonth()->format('Y-m-d');
        $daysInMonth = Carbon::parse($startOfMonth)->daysInMonth;
        $working_days = Carbon::parse($startOfMonth)->diffInDaysFiltered(function (Carbon $date) {
            return $date->isWeekday();
        }, Carbon::parse($endOfMonth)->addDays(1));
        $offDays = $daysInMonth - $working_days;

        $employees = User::orderBy('employee_id')->where('id', auth()->user()->id)->get();
        $company_setting = CompanySetting::findOrFail(1);
        $periods = new CarbonPeriod($startOfMonth, $endOfMonth);
        $attendances = CheckinCheckout::whereYear('date', $year)->whereMonth('date', $month)->get();
        return view('components.payroll_table', compact('employees', 'company_setting', 'periods', 'attendances', 'daysInMonth', 'working_days', 'offDays', 'month', 'year'))->render();
    }
}
