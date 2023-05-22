<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\CheckinCheckout;
use Illuminate\Support\Facades\Hash;

class AttendanceScanController extends Controller
{
    public function scan () {
        return view('attendance_scan');
    }

    public function scanStore (Request $request) {
        if(Carbon::now()->isSaturday() || Carbon::now()->isSunday()){
            return [
                'status' => 'fail',
                'message' => 'Today is off day'
            ];
        }
        
        if(!Hash::check(date('Y-m-d'), $request->hash_value)) {
            return [
                'status' => 'fail',
                'message' => 'QR is invalid.'
            ];  
        }

        $employee = auth()->user();

        $checkin_checkout_data = CheckinCheckout::firstOrCreate(
            [
                'user_id' => $employee->id,
                'date' => now()->format('Y-m-d')
            ]
        );

        if($checkin_checkout_data->checkin_time && $checkin_checkout_data->checkout_time) {
            return [
                'status' => 'fail',
                'message' => 'Already check in and check out today.'
            ];
        }

        if(is_null($checkin_checkout_data->checkin_time)) {
            $checkin_checkout_data->checkin_time = now();
            $message = 'Successfully Checkin at ' . now();
        }else {
            if(is_null($checkin_checkout_data->checkout_time)) {
                $checkin_checkout_data->checkout_time = now();
                $message = 'Successfully Checkout at ' . now();
            }
        }

        $checkin_checkout_data->update();
        
        return [
            'status' => 'success',
            'message' => $message,
        ];

    }
    
}
