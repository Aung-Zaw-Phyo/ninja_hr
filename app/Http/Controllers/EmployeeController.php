<?php

namespace App\Http\Controllers;

use Yajra\DataTables\Facades\DataTables;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class EmployeeController extends Controller
{
    public function index () {
        return view('employee.index');
    }

    public function ssd () {
        $data = User::query();
            return Datatables::of($data)
            ->addColumn('department', function($each) {
                return $each->department ? $each->department->title : '-';
            })
            ->editColumn('is_present', function($each) {
                if($each->is_present == 1){
                    return "<span class='badge badge-pill badge-success'>Present</span>";
                }else {
                    return "<span class='badge badge-pill badge-danger'>Leave</span>";
                }
            })
            ->rawColumns(['is_present'])
            ->make(true);
    }
}
