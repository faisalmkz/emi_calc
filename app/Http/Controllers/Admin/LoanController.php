<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LoanDetails;
use Illuminate\Http\Request;

class LoanController extends Controller
{
    
    public function index()
    {
        $loanDetails = LoanDetails::paginate(15);

        return view('admin.loan.list', compact('loanDetails'));
    }
}
