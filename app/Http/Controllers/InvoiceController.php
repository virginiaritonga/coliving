<?php

namespace App\Http\Controllers;

use PDF;
use App\Room;
use App\Tenant;
use App\Booking;
use App\Invoice;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class InvoiceController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $invoices = Invoice::orderby('created_at','DESC');
        return view('invoices.index',compact('invoices'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $bookings = Booking::find($id);
        $invoice = new Invoice;
        $subtotal_room = $invoice->countSubTotalRoomPrice($id);
        return view('invoices.create',compact('bookings','subtotal_room'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,$id)
    {

           //validate
        $validator = Validator::make($request->all(), [
            'discount' => 'required|numeric',
            'additional_cost' => 'required|numeric',
            'is_paid' => 'required',
            'payment_method' => 'required',
        ],[
            'discount.required' => 'Discount required',
            'discount.numeric' => 'Discount must be number',
            'additional_cost.required' => 'Additional Cost required',
            'additional_cost.numeric' => 'Additional Cost must be number',
            'is_paid.required' => 'Paid status required',
            'payment_method.required' => 'Payment Method required',
        ]);

        if ($validator->fails()) {
            return redirect()->route('invoice.create',$id)
                        ->withErrors($validator)
                        ->withInput();
        }

        try {
            //instansiasi Invoice
            $invoices = new Invoice($request->all());
            $invoices->invoice_date = date("Y-m-d H:i:s");
            $invoices->booking_id = $id;
            $invoices->invoice_number = 'Invoice-'.date("dmY").'-'.$invoices->booking_id;


             //store data
            $invoices->save();

            // dd($invoices);

            return redirect()->route('invoice.show',$invoices->id)->with(['success' => 'Data created successfully!']);
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $invoices = Invoice::findOrFail($id);
        $bookings = Booking::with('tenants','rooms')->find($invoices->booking_id);
        $tenants = $bookings->tenants;
        $rooms = $bookings->rooms;
        $rent_days = $invoices->countRentDays($bookings->checkin_date, $bookings->checkout_date);
        $subtotal_room = $invoices->countSubTotalRoomPrice($invoices->booking_id);
        $total_payment = $invoices->countTotalPayment($invoices);

        return view('invoices.show',compact('invoices','tenants','rooms','bookings','rent_days','subtotal_room','total_payment'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $invoices = Invoice::with('bookings')->find($id);
        $bookings = Booking::with('tenants','rooms')->find($invoices->booking_id);
        //subtotal dan total payment sebelumnya
        $subtotal_room = $invoices->countSubTotalRoomPrice($invoices->booking_id);
        $total_payment = $invoices->countTotalPayment($invoices);
        $rent_days = $invoices->countRentDays($bookings->checkin_date, $bookings->checkout_date);

        $tenants = Tenant::all();
        $rooms = Room::all();

        //menampilkan room yang sebelumnya dipilih
        $room_selected = [];
        foreach($bookings->rooms as $room){
            $room_selected[] = $room->id;
        }

        //menampilkan tenant yang sebelumnya dipilih
        $tenant_selected = [];
        foreach($bookings->tenants as $tenant){
            $tenant_selected[] = $tenant->id;
        }

        return view('invoices.edit',compact('invoices','room_selected', 'tenant_selected','tenants','rooms','bookings','subtotal_room','total_payment','rent_days'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
            //validate
            $validator = Validator::make($request->all(), [
                'discount' => 'required|numeric',
                'additional_cost' => 'required|numeric',
                'is_paid' => 'required',
                'payment_method' => 'required',
            ],[
                'discount.required' => 'Discount required',
                'discount.numeric' => 'Discount must be number',
                'additional_cost.required' => 'Additional Cost required',
                'additional_cost.numeric' => 'Additional Cost must be number',
                'is_paid.required' => 'Paid status required',
                'payment_method.required' => 'Payment Method required',
            ]);

            if ($validator->fails()) {
                return redirect()->route('invoice.edit',$id)
                            ->withErrors($validator)
                            ->withInput();
            }

        try {
            //id invoice
            $invoices = Invoice::findOrFail($id);

            $invoices->invoice_number = 'Invoice-'.date("dmY").'-'.$invoices->booking_id;
            $invoices->invoice_date = date("Y-m-d H:i:s");
            $invoices->discount = $request->discount;
            $invoices->additional_cost = $request->additional_cost;
            $invoices->payment_method = $request->payment_method;
            $invoices->is_paid = $request->is_paid;
            $invoices->update();

            return redirect()->route('invoice.show',$invoices->id)->with(['success-invoice' => 'Data Invoice updated successfully!']);
        } catch (\Exception $e) {
            return redirect()->back()->with(['error-invoice' => $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $invoices = Invoice::findOrFail($id);
        $invoices->delete();

        return redirect()->back()->with(['success' => 'Data invoice <strong> #'.$invoices->invoice_numeric.' </strong> deleted successfully !!']);
    }

    /**
     * function for generate invoice into pdf
     *
     * @param  invoice id
     * @return pdf stream
     */
    public function generateInvoice($id){
        //Get data invoice berdasarkan ID
        $invoices = Invoice::find($id);
        $bookings = Booking::with('tenants','rooms')->find($invoices->booking_id);
        $tenants = $bookings->tenants;
        $rooms = $bookings->rooms;
        $rent_days = $invoices->countRentDays($bookings->checkin_date, $bookings->checkout_date);
        $subtotal_room = $invoices->countSubTotalRoomPrice($invoices->booking_id);
        $total_payment = $invoices->countTotalPayment($invoices);

        //Load PDF yang merujuk ke view invoice-pdf.blade.php dengan mengirimkan data dari invoice
        //kemudian menggunakan pengaturan paper landscape A5
        $pdf = PDF::loadView('invoices.invoice-pdf', compact('invoices','tenants','rooms','rent_days','subtotal_room','total_payment'))->setPaper('a5', 'landscape');
        return $pdf->stream($invoices->invoice_number);
    }


}

