<?php

use Illuminate\Database\Seeder;

class InvoicesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('invoices')->delete();
        
        \DB::table('invoices')->insert(array (
            0 => 
            array (
                'id' => 1,
                'invoice_number' => 'Invoice-14092020-1',
                'invoice_date' => '2020-09-14 09:54:38',
                'discount' => 0,
                'additional_cost' => 170000,
                'is_paid' => 'paid',
                'payment_method' => 'cash',
                'booking_id' => 1,
                'created_at' => '2020-09-14 09:54:38',
                'updated_at' => '2020-09-14 09:54:38',
            ),
            1 => 
            array (
                'id' => 2,
                'invoice_number' => 'Invoice-15092020-2',
                'invoice_date' => '2020-09-15 09:28:13',
                'discount' => 12000,
                'additional_cost' => 20000,
                'is_paid' => 'paid',
                'payment_method' => 'cash',
                'booking_id' => 2,
                'created_at' => '2020-09-15 09:28:13',
                'updated_at' => '2020-09-15 09:28:13',
            ),
            2 => 
            array (
                'id' => 3,
                'invoice_number' => 'Invoice-15092020-5',
                'invoice_date' => '2020-09-15 09:29:37',
                'discount' => 0,
                'additional_cost' => 0,
                'is_paid' => 'paid',
                'payment_method' => 'cash',
                'booking_id' => 5,
                'created_at' => '2020-09-15 09:29:37',
                'updated_at' => '2020-09-15 09:29:37',
            ),
        ));
        
        
    }
}