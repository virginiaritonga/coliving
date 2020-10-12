<?php

namespace App\Http\Controllers\Api;

use App\Room;
use App\Type;
use DateTime;
use App\Booking;
use App\Invoice;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class IncomeChartsApiController extends Controller
{

    /**
     * function to get daily income data
     * @param yyyy-mm-dd
     */
    public function getDailyIncomeData($month){
        //nilai awal
        $income_total = 0;
        $unpaid_total = 0;
        //hari pertama dalam bulan yang dipilih
        $first_day = Carbon::parse($month)->firstOfMonth()->format('Y-m-d H:i:s');
        //hari yang dipilih
        $last_day = Carbon::parse($month)->format('Y-m-d H:i:s');
        //range dibuat setiap 1 hari
        foreach(CarbonPeriod::create($first_day, '1 day', $last_day) as $day){
            //set format date untuk pencarian di database
            $number = $day->format('Y-m-d');
            //mengambil data invoice dengan invoice_date sama dengan tanggal bulan yang dilooping
            $invoices = Invoice::where('invoice_date', 'like', '%' . $number . '%')->get();
            //nilai awal
            $income = 0;
            $unpaid = 0;
            //melakukan perhitungan jumlah total_payment untuk invoice date dengan hari yang sama dari status invoice unpaid dan paid
            foreach ($invoices as $invoice) {
                if ($invoice->is_paid == 'unpaid') {
                    //untuk invoice unpaid, hasil dimasukkan ke dalam variabel $unpaid
                    $unpaid += $invoice->countTotalPayment($invoice);
                }else{
                    //jika invoice paid, maka hasil dimasukkan ke variabel income
                    $income += $invoice->countTotalPayment($invoice);
                }
            }
            //melakukan penjumlahan seluruh total income pada bulan tersebut
            $income_total += $income;
            //melakukan penjumlahan seluruh total unpaid pada bulan tersebut
            $unpaid_total += $unpaid;
            //merubah format hari menjadi berbentuk seperti '21 Aug', dan dimasukkan ke dalam array
            $days[] = $day->format('d F');
            //memasukkan total income per hari ke dalam array
            $incomes[] = $income;
            //memasukkan total unpaid per hari ke dalam array
            $unpaids[] = $unpaid;
        }
        //set format ke mata uang rupiah
        $income_total = number_format($income_total);
        $unpaid_total = number_format($unpaid_total);

        //seluruh data dikumpulkan di dalam array daily_income_data_array
        $daily_income_data_array = array(
            'days' => $days,
            'daily_income_count_data' => $incomes,
            'daily_unpaid_count_data' => $unpaids,
            'incomes_total_of_month' => $income_total,
            'unpaid_total_of_month' => $unpaid_total,
        );


        //generate ke json
        return response()->json($daily_income_data_array);
    }

     /**
      * function to get monthly income data
     * @param yyyy-mm
     */
    public function getMonthlyIncomeData($year){
        //nilai awal
        $income_total = 0;
        $unpaid_total = 0;
        //bulan pertama dalam bulan yang dipilih
        $first_month = Carbon::parse($year)->firstOfYear()->format('Y-m-d H:i:s');
        //bulan yang dipilih
        $last_month = Carbon::parse($year)->format('Y-m-d H:i:s');
        //range dibuat setiap 1 bulan
        foreach(CarbonPeriod::create($first_month, '1 month', $last_month) as $month){
            //set format date untuk pencarian di database
            $number = $month->format('Y-m');
            //mengambil data invoice dengan bulan invoice_date sama dengan bulan yang dilooping
            $invoices = Invoice::where('invoice_date', 'like', '%' . $number . '%')->get();
            //nilai awal
            $income = 0;
            $unpaid = 0;
            //melakukan perhitungan jumlah total_payment untuk invoice date dengan bulan dan tahun yang sama dari status invoice unpaid dan paid
            foreach ($invoices as $invoice) {

                if ($invoice->is_paid == 'unpaid') {
                    //untuk invoice unpaid, hasil dimasukkan ke dalam variabel $unpaid
                    $unpaid += $invoice->countTotalPayment($invoice);
                }else{
                    //jika invoice paid, maka hasil dimasukkan ke variabel income
                    $income += $invoice->countTotalPayment($invoice);
                }
            }
            //melakukan penjumlahan seluruh total income pada tahun tersebut
            $income_total += $income;
            //melakukan penjumlahan seluruh total unpaid pada tahun tersebut
            $unpaid_total += $unpaid;
            //merubah format hari menjadi berbentuk seperti 'Aug', dan dimasukkan ke dalam array
            $months[] = $month->format('F');
            //memasukkan total income per bulan ke dalam array
            $incomes[] = $income;
            //memasukkan total unpaid per bulan ke dalam array
            $unpaids[] = $unpaid;
        }
        //set format ke mata uang rupiah
        $income_total = number_format($income_total);
        $unpaid_total = number_format($unpaid_total);

        //seluruh data dikumpulkan di dalam array monthly_income_data_array
        $monthly_income_data_array = array(
            'months' => $months,
            'monthly_income_count_data' => $incomes,
            'monthly_unpaid_count_data' => $unpaids,
            'incomes_total_of_year' => $income_total,
            'unpaid_total_of_year' => $unpaid_total,
        );

        //generate ke json
        return response()->json($monthly_income_data_array);
    }

    /**
     * function to get yearly income data
     * @param yyyy-mm,yyyy-mm
     */
    public function getYearlyIncomeData($start_year, $end_year){
        $start_year = $start_year.'-01';
        $end_year = $end_year.'-12';
        //nilai awal
        $income_total = 0;
        $unpaid_total = 0;
        //tahun pertama yang dipilih
        $start_year = Carbon::parse($start_year)->firstOfYear()->format('Y-m-d H:i:s');
        //tahun terakhir yang dipilih
        $end_year = Carbon::parse($end_year)->endOfYear()->format('Y-m-d H:i:s');
        // dd($start_year, $end_year);
        //range dibuat setiap 1 tahun
        foreach(CarbonPeriod::create($start_year, '1 year', $end_year) as $year){
            //set format date untuk pencarian di database
            $number = $year->format('Y');
            //mengambil data invoice dengan bulan invoice_date sama dengan tahun yang dilooping
            $invoices = Invoice::where('invoice_date', 'like', '%' . $number . '%')->get();
            //nilai awal
            $income = 0;
            $unpaid = 0;
            //melakukan perhitungan jumlah total_payment untuk invoice date dengan tahun yang sama dari status invoice unpaid dan paid
            foreach ($invoices as $invoice) {

                if ($invoice->is_paid == 'unpaid') {
                    //untuk invoice unpaid, hasil dimasukkan ke dalam variabel $unpaid
                    $unpaid += $invoice->countTotalPayment($invoice);
                }else{
                    //jika invoice paid, maka hasil dimasukkan ke variabel income
                    $income +=$invoice->countTotalPayment($invoice);
                }
            }
            //melakukan penjumlahan seluruh total income pada range tahun tersebut
            $income_total += $income;
            //melakukan penjumlahan seluruh total unpaid pada range tahun tersebut
            $unpaid_total += $unpaid;
            //merubah format hari menjadi berbentuk seperti '2020', dan dimasukkan ke dalam array
            $years[] = $year->format('Y');
            //memasukkan total income per tahun ke dalam array
            $incomes[] = $income;
            //memasukkan total unpaid per tahun ke dalam array
            $unpaids[] = $unpaid;
        }
        //set format ke mata uang rupiah
        $income_total = number_format($income_total);
        $unpaid_total = number_format($unpaid_total);

        //seluruh data dikumpulkan di dalam array yearly_income_data_array
        $yearly_income_data_array = array(
            'years' => $years,
            'yearly_income_count_data' => $incomes,
            'yearly_unpaid_count_data' => $unpaids,
            'incomes_total_between_year' => $income_total,
            'unpaid_total_between_year' => $unpaid_total,
        );

        //generate ke json
        return response()->json($yearly_income_data_array);
    }

    /**
     *
     *function to get data income for datatable
     * @param yyyy-mm-dd,yyyy-mm-dd
     */
    public function getIncome(Request $request){
        if(request()->ajax()){
            if(!empty($request->from_date)){
                $data = Invoice::whereBetween('invoice_date', array($request->from_date, $request->to_date))->get();
            }else{
                $data = Invoice::orderby('invoice_date','DESC')->get();
            }

            foreach ($data as $invoice) {
                $booking = Booking::with('tenants','rooms')->find($invoice->booking_id);

                $invoice->invoice_date = Carbon::parse($invoice->invoice_date)->format('d M Y H:i:s');
                $invoice->total_payment = number_format($invoice->countTotalPayment($invoice));

                $invoice->booking_id = 'Booking #'.$booking->id;
                $invoice->booking_date = Carbon::parse($booking->booking_date)->format('d M Y H:i:s');
                //get tenant
                $tenants_array = [];
                foreach($booking->tenants as $tenant){
                    $tenants = $tenant->tenant_name;
                    array_push($tenants_array, $tenants);
                }
                $invoice->tenant =  $tenants_array;
                //get room
                $rooms_array = [];
                foreach($booking->rooms as $room){
                    $rooms = 'No. '.$room->no_room.' Type '.$room->types->type_name;
                    array_push($rooms_array, $rooms);
                }
                $invoice->room =  $rooms_array;

            }

            return datatables()->of($data)
                ->addIndexColumn()
                ->addColumn('actions', function ($invoice) {
                    return '<a class="btn btn-primary btn-circle btn-sm" href="'. route("invoice.show", $invoice->id) .'"><i class="fas fa-print"></i></a>';})
                ->rawColumns(['actions'])
                ->make(true);
        }
    }


    /**
     * INCOME BY TYPE
     */
    public function getIncomeByType(){

        $types = Type::all();

        $type_name_array = [];
        $total_income_array = [];
        foreach($types as $type){

            $type_id = $type->id;

            $type_name = $type->type_name;
            array_push($type_name_array, $type_name);

            $bookings = Booking::whereHas('rooms',function($query) use($type_id){
                            $query->where('type_id','=',$type_id);
                        })
                        ->whereHas('invoices', function($query){
                            $query->where('is_paid','=','paid');
                        })
                        ->get();

            $total = 0;
            foreach($bookings as $booking){
                $rent_days  = $this->countRentDays($booking->checkin_date, $booking->checkout_date);
                $subtotal_room = 0;

                foreach($booking->rooms as $room){

                    if($room->types->id == $type_id)
                    $subtotal_room += $room->types->rent_price * $rent_days;
                }

                $total += $subtotal_room;
            }
            array_push($total_income_array, $total);
        }
        $total_income_by_type = $total_income_array;
        $types_name = $type_name_array;

        // dd($bookings);

        $income_by_type = array(
            'types' => $types_name,
            'total_income_by_type' => $total_income_by_type,
        );

        return response()->json($income_by_type);
    }

    /**
     * function to count rent days
     */
    public function countRentDays($start, $end){

        //start
        $start_rent = Carbon::parse($start);
        //end
        $end_rent = Carbon::parse($end);
        //count total rent days use diffInDays()
        $rent_days  = $start_rent->diffInDays($end_rent);

        return $rent_days;
    }





}
