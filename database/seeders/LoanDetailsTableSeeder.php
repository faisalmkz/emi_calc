<?php

namespace Database\Seeders;

use App\Models\LoanDetails;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class LoanDetailsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (!LoanDetails::where('clientid', 1001)->exists()) {
            $details = new LoanDetails();
            $details->clientid = 1001;
            $details->num_of_payment = 12;
            $details->first_payment_date = "2018-06-29";
            $details->last_payment_date = "2019-05-29";
            $details->loan_amount = 1550.00;
            $details->created_at = Carbon::now();
            $details->save();
        }
        if (!LoanDetails::where('clientid', 1003)->exists()) {
            $details = new LoanDetails();
            $details->clientid = 1003;
            $details->num_of_payment = 7;
            $details->first_payment_date = "2019-02-15";
            $details->last_payment_date = "2019-08-15";
            $details->loan_amount = 6851.94;
            $details->created_at = Carbon::now();
            $details->save();
        }
        if (!LoanDetails::where('clientid', 1005)->exists()) {
            $details = new LoanDetails();
            $details->clientid = 1005;
            $details->num_of_payment = 17;
            $details->first_payment_date = "2017-11-09";
            $details->last_payment_date = "2019-03-09";
            $details->loan_amount = 1800.01;
            $details->created_at = Carbon::now();
            $details->save();
        }
    }
}
