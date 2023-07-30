<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LoanDetails;
use DateInterval;
use DatePeriod;
use DateTime;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class ProcessController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $emiDetails = DB::table('emi_details')->get();

        $firstRow = $emiDetails->first();
        $monthColumns = collect($firstRow)->except(['id', 'clientid'])->keys()->toArray();
    
        // Prepare the table header with the column names
        $tableHeader = array_merge(['clientid'], $monthColumns);
        $tableRows = $emiDetails->map(function ($emi) use ($monthColumns) {
            $row = [];
            $row[] = $emi->clientid;
    
            foreach ($monthColumns as $month) {
                $row[] = $emi->{$month};
            }
    
            return $row;
        });

        return view('admin.emi.list', compact('tableHeader', 'tableRows'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $minAndMaxDates = DB::table('loan_details')
            ->select(DB::raw('MIN(first_payment_date) as min_date, MAX(last_payment_date) as max_date'))
            ->first();
        if (!$minAndMaxDates) {
            return 'No records found in loan_details table.';
        }
        $minDate = $minAndMaxDates->min_date;
        $maxDate = $minAndMaxDates->max_date;


        $start = new DateTime($minDate);
        $end = new DateTime($maxDate);
        $end = $end->modify('+1 month'); // To include the last month
        $interval = DateInterval::createFromDateString('1 month');
        $period = new DatePeriod($start, $interval, $end);

        $monthColumns = [];
        foreach ($period as $dt) {
            $month = $dt->format('Y_M');
            $monthColumns[] = "$month DECIMAL(10, 2)";
        }

        // Step 3: Construct the SQL query dynamically to create the emi_details table
        $allColumns =  implode(',', array_merge(["id INT AUTO_INCREMENT PRIMARY KEY", "clientid INT"], $monthColumns));

        // Check if the table exists
        $tableExists = DB::select("SHOW TABLES LIKE 'emi_details'");

        if (count($tableExists) > 0) {
            // If the table exists, drop it
            DB::statement("DROP TABLE emi_details");
        }

        // Create the table with the required columns using RAW SQL query
        DB::statement("CREATE TABLE emi_details ($allColumns)");

        $loanData = DB::table('loan_details')->get();
        foreach ($loanData as $row) {
            $clientid = $row->clientid;
            $numOfPayments = $row->num_of_payment;
            $loanAmount = $row->loan_amount;
            $emiAmount = $loanAmount / $numOfPayments;

            $start = new DateTime($row->first_payment_date);
            $end = new DateTime($row->last_payment_date);
            $end->add(new DateInterval('P1M')); // To include the last month
            $interval = new DateInterval('P1M');
            $period = new DatePeriod($start, $interval, $end);

            foreach ($period as $dt) {
                $monthColumn = $dt->format('Y_M');

                // Save the EMI amount into the corresponding month column in the emi_details table
                DB::table('emi_details')->updateOrInsert(
                    ['clientid' => $clientid],
                    [$monthColumn => $emiAmount]
                );
            }
        }
        return redirect()->route('process.index');

        Session::flash('message', 'You have been successfully completed.');
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
