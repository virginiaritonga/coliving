<?php

use Illuminate\Database\Seeder;

class BookingsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('bookings')->delete();
        
        \DB::table('bookings')->insert(array (
            0 => 
            array (
                'id' => 1,
                'booking_date' => '2020-09-14 09:37:11',
                'checkin_date' => '2020-09-14 09:37:00',
                'checkout_date' => '2020-09-16 09:37:00',
                'status' => 'checked-out',
                'created_at' => '2020-09-14 09:37:11',
                'updated_at' => '2020-09-14 10:52:11',
            ),
            1 => 
            array (
                'id' => 2,
                'booking_date' => '2020-09-14 09:58:07',
                'checkin_date' => '2020-09-15 09:57:00',
                'checkout_date' => '2020-09-17 09:57:00',
                'status' => 'checked-out',
                'created_at' => '2020-09-14 09:58:07',
                'updated_at' => '2020-09-14 10:51:54',
            ),
            2 => 
            array (
                'id' => 3,
                'booking_date' => '2020-09-14 10:52:39',
                'checkin_date' => '2020-09-23 10:52:00',
                'checkout_date' => '2020-09-24 10:52:00',
                'status' => 'checked-in',
                'created_at' => '2020-09-14 10:52:39',
                'updated_at' => '2020-09-14 10:56:26',
            ),
            3 => 
            array (
                'id' => 4,
                'booking_date' => '2020-09-15 09:28:48',
                'checkin_date' => '2020-09-18 09:28:00',
                'checkout_date' => '2020-09-19 09:28:00',
                'status' => 'booked',
                'created_at' => '2020-09-15 09:28:48',
                'updated_at' => '2020-09-15 09:28:48',
            ),
            4 => 
            array (
                'id' => 5,
                'booking_date' => '2020-09-15 09:29:27',
                'checkin_date' => '2019-05-15 09:28:00',
                'checkout_date' => '2020-09-19 09:29:00',
                'status' => 'checked-out',
                'created_at' => '2020-09-15 09:29:27',
                'updated_at' => '2020-09-15 09:29:31',
            ),
        ));
        
        
    }
}