<?php

namespace App\Http\Controllers;

use App\Invoice;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        //menampilkan data invoice
        $invoices = Invoice::orderby('created_at','DESC')->get();
        $invoices = Invoice::all();
        $total_unpaid = 0;
        $total_income = 0;
        foreach ($invoices as $invoice) {
            if ($invoice->is_paid == 'unpaid') {
                //untuk invoice unpaid
                $total_unpaid += $invoice->countTotalPayment($invoice);
            }else{
                //jika invoice paid
                $total_income +=$invoice->countTotalPayment($invoice);
            }
        }

        return view('report.index',compact('invoices','total_unpaid','total_income'));
    }


}
