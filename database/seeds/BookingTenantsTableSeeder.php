<?php

use Illuminate\Database\Seeder;

class BookingTenantsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('booking_tenants')->delete();
        
        \DB::table('booking_tenants')->insert(array (
            0 => 
            array (
                'id' => 1,
                'booking_id' => 1,
                'tenant_id' => 2,
                'created_at' => '2020-09-14 09:37:11',
                'updated_at' => '2020-09-14 09:37:11',
            ),
            1 => 
            array (
                'id' => 4,
                'booking_id' => 2,
                'tenant_id' => 1,
                'created_at' => '2020-09-14 09:58:07',
                'updated_at' => '2020-09-14 09:58:07',
            ),
            2 => 
            array (
                'id' => 5,
                'booking_id' => 3,
                'tenant_id' => 3,
                'created_at' => '2020-09-14 10:52:39',
                'updated_at' => '2020-09-14 10:52:39',
            ),
            3 => 
            array (
                'id' => 6,
                'booking_id' => 4,
                'tenant_id' => 3,
                'created_at' => '2020-09-15 09:28:48',
                'updated_at' => '2020-09-15 09:28:48',
            ),
            4 => 
            array (
                'id' => 7,
                'booking_id' => 5,
                'tenant_id' => 5,
                'created_at' => '2020-09-15 09:29:27',
                'updated_at' => '2020-09-15 09:29:27',
            ),
        ));
        
        
    }
}