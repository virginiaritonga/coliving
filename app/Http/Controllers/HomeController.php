<?php

namespace App\Http\Controllers;

use App\Room;
use DateTime;
use App\Tenant;
use App\Invoice;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        //mengambil 5 buah room yang diupdate terakhir kali
        $rooms = Room::orderby('updated_at','DESC')->take(5)->get();

        //mengambil jumlah room yang tersedia
        $available_room = Room::where('status','available')->count();

        //mengambil jumlah room yang dibooking
        $booked_room = Room::where('status','booked')->count();

        //mengambil 5 tenant yang sedang checkin atau booking
        $tenants = Tenant::whereHas('bookings', function($query) {
            $query->where('status','checked-in')->orWhere('status','booked');
        })->take(5)->get();

        //mengambil tenant yang menginap / booking
        $active_tenant = $tenants->count();

        //menghitung THIS MONTH INCOME
        $income = $this->countIncome();

        return view('home',compact('available_room','booked_room','rooms','tenants','active_tenant','income'));
    }

    /**
     * function untuk menghitung income bulan ini
     */
    private function countIncome(){
        //get tanggal awal bulan
        $day = new DateTime('first day of this month 00:00:00');
        //start time penghitungan income (awal bulan)
        $time_from = Carbon::parse($day)->format('Y-m-d H:i:s');
        //end time penghitungan income (saat ini)
        $time_to = Carbon::parse(now())->format('Y-m-d H:i:s');
        // dd($time_from, $time_to);
        //get data invoice dari waktu yang diinginkan (start time to end time)
        $invoices = Invoice::whereBetween('invoice_date',[$time_from, $time_to])->where('is_paid','paid')->get();
        //nilai awal income
        $income = 0;
        //penjumlahan income dari total_paid
        foreach($invoices as $invoice){
            $income += $invoice->countTotalPayment($invoice);
        }
        //mengembalikan hasil income
        return $income;
    }



}


