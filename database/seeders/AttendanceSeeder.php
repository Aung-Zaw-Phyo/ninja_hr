<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\CarbonPeriod;
use App\Models\CheckinCheckout;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class AttendanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::all();
        foreach ($users as $user) {
            $periods = new CarbonPeriod('2023-06-01', '2023-06-30');
            foreach($periods as $period) {
                $attendance = new CheckinCheckout();
                $attendance->user_id = $user->id;
                $attendance->date = $period->format('Y-m-d');
                $attendance->checkin_time = Carbon::parse($period->format('Y-m-d') . ' ' . '9:00:00')->subMinutes(rand(1, 55));
                $attendance->checkout_time = Carbon::parse($period->format('Y-m-d') . ' ' . '18:00:00')->addMinutes(rand(1, 55));
                $attendance->save();
            }
        }
    }
}
