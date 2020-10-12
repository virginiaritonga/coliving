<?php

namespace App\Http\Controllers\Api;

use App\Tenant;
use App\Http\Controllers\Controller;

class TenantChartsApiController extends Controller
{

    /**
     * ini function yang dipakai untuk menampilkan yearly report chart
     *
     * menampilkan data income setiap seluruh bulan january s/d december
     */
    public function getMonthlyTenantData($year){
        $monthly_tenant_count_array = [];
        for($bulan = 1;$bulan < 13;$bulan++){
            //lakukan cek tanggal, jika hanya 1 angka (1-9) maka tambahkan 0 di depannya
            $f_date = strlen($bulan) == 1 ? 0 . $bulan:$bulan;
            //get data sum total_payment berdasarkan bulan
            $monthly_tenant_count = Tenant::whereMonth('created_at',$f_date)->whereYear('created_at',$year)->get()->count();
            //memasukkan hasil ke array monthly_tenant_count
            array_push($monthly_tenant_count_array, $monthly_tenant_count);
        }

        $max_no = max($monthly_tenant_count_array);
        $max = round(($max_no + 10/2)/10) * 10;
        $monthly_tenant_data_array = array(
            'months' => ["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sept","Oct","Nov","Dec"],
            'monthly_tenant_count_data' => $monthly_tenant_count_array,
            'max' => $max,
        );

        return response()->json($monthly_tenant_data_array);
    }



}
