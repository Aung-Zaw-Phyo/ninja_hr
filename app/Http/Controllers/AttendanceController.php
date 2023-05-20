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

class AttendanceController extends Controller
{
    public function index () {
        if (!auth()->user()->can('view_attendance')) {
            abort(403, 'Unauthorized Action');
        }

        return view('attendance.index');
    }

    public function ssd () {
        if (!auth()->user()->can('view_attendance')) {
            abort(403, 'Unauthorized Action');
        }

        $data = CheckinCheckout::with('employee');
        return Datatables::of($data)
            ->filterColumn('employee_name', function ($query, $keyword) {
                $query->whereHas('employee', function ($q1) use ($keyword) {
                    $q1->where('name', 'like', '%' . $keyword .'%');
                });
            })
            ->addColumn('employee_name', function($each) {
                return $each->employee ? $each->employee->name : '-';
            })
            ->editColumn('updated_at', function($each) {
                return Carbon::parse($each->updated_at)->format('Y-m-d H:i:s');
            })
            ->addColumn('plus-icon', function($each){
                return null;
            })
            ->addColumn('action', function($each) {
                $edit_icon = '';
                $delete_icon = '';

                if (auth()->user()->can('edit_attendance')) {
                    $edit_icon = '<a href="'.route('attendance.edit', $each->id).'" class="text-warning"><i class="fas fa-edit"></i></a>';
                }

                if (auth()->user()->can('delete_attendance')) {
                    $delete_icon = '<a href="#" class="text-danger delete-btn" data-id="'.$each->id.'"><i class="fas fa-trash-alt"></i></a>';
                }


                return '<div class="action-icon text-start">'.$edit_icon.$delete_icon.'</div>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function create () {
        if (!auth()->user()->can('create_attendance')) {
            abort(403, 'Unauthorized Action');
        }

        $employees = User::orderBy('employee_id')->get();
        return view('attendance.create', compact('employees'));
    }

    public function store (StoreAttendance $request) {
        if (!auth()->user()->can('create_attendance')) {
            abort(403, 'Unauthorized Action');
        }
        
        if(CheckinCheckout::where('user_id', $request->user_id)->where('date', $request->date)->exists()){
            return back()->withErrors(['fail' => 'Already defined.'])->withInput();
        }

        $attendance = new CheckinCheckout();
        $attendance->user_id = $request->user_id;
        $attendance->date = $request->date;
        $attendance->checkin_time = $request->checkin_time == '00:00:00' ? NULL : $request->date . ' ' . $request->checkin_time;
        $attendance->checkout_time = $request->checkout_time == '00:00:00' ? NULL : $request->date . ' ' . $request->checkout_time;
        $attendance->save();

        return redirect()->route('attendance.index')->with('create', 'Attendance is successfully created.');
    }

    public function edit ($id) {
        if (!auth()->user()->can('edit_attendance')) {
            abort(403, 'Unauthorized Action');
        }

        $attendance = CheckinCheckout::findOrFail($id);
        $employees = User::orderBy('employee_id')->get();
        return view('attendance.edit', compact('attendance', 'employees'));
    }

    public function update($id, UpdateAttendance $request) {
        if (!auth()->user()->can('edit_attendance')) {
            abort(403, 'Unauthorized Action');
        }

        $attendance = CheckinCheckout::findOrFail($id);

        if(CheckinCheckout::where('user_id', $request->user_id)->where('date', $request->date)->where('id', '!=', $id)->exists()){
            return back()->withErrors(['fail' => 'Already defined.'])->withInput();
        }

        $attendance->user_id = $request->user_id;
        $attendance->date = $request->date;
        $attendance->checkin_time = $request->checkin_time == '00:00:00' ? NULL : $request->date . ' ' . $request->checkin_time;
        $attendance->checkout_time = $request->checkout_time == '00:00:00' ? NULL : $request->date . ' ' . $request->checkout_time;
        $attendance->update();

        return redirect()->route('attendance.index')->with('update', 'Attendance is successfully updated.');
    }

    

    public function destroy ($id) {
        if (!auth()->user()->can('delete_attendance')) {
            abort(403, 'Unauthorized Action');
        }

        $attendance = CheckinCheckout::findOrFail($id);
        $attendance->delete();
        return 'success';
    }

    public function overview (Request $request) {
        if (!auth()->user()->can('view_attendance_overview')) {
            abort(403, 'Unauthorized Action');
        }

        return view('attendance.overview');
    }

    public function overviewTable (Request $request) {
        if (!auth()->user()->can('view_attendance_overview')) {
            abort(403, 'Unauthorized Action');
        }

        $employee_name = $request->employee_name;
        $month = $request->month;
        $year = $request->year;

        $startOfMonth = $year . '-' . $month . '-01' ; //2023-05-01
        $endOfMonth = Carbon::parse($startOfMonth)->endOfMonth()->format('Y-m-d');

        $employees = User::orderBy('employee_id')->where('name', 'like', '%' . $employee_name .'%')->get();
        $company_setting = CompanySetting::findOrFail(1);
        $periods = new CarbonPeriod($startOfMonth, $endOfMonth);
        $attendances = CheckinCheckout::whereYear('date', $year)->whereMonth('date', $month)->get();
        return view('components.attendance_overview_table', compact('employees', 'company_setting', 'periods', 'attendances'))->render();
    }
}
