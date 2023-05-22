<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\CompanySetting;
use App\Models\CheckinCheckout;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class CheckinCheckoutController extends Controller
{
    public function CheckInCheckOut () {
        $hash_value = Hash::make(date('Y-m-d'));
        return view('checkin_checkout', compact('hash_value'));
    }

    public function CheckInCheckOutStore (Request $request) {
        if(Carbon::now()->isSaturday() || Carbon::now()->isSunday()){
            return [
                'status' => 'fail',
                'message' => 'Today is off day'
            ];
        }
        
        $employee = User::where('pin_code', $request->pin_code)->first();

        if(!$employee) {
            return [
                'status' => 'fail',
                'message' => 'Pin Code is wrong.'
            ];
        }

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
