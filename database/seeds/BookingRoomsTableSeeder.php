<?php

use Illuminate\Database\Seeder;

class BookingRoomsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        \DB::table('booking_rooms')->delete();

        \DB::table('booking_rooms')->insert(array (
            0 =>
            array (
                'id' => 1,
                'booking_id' => 1,
                'room_id' => 7,
                'created_at' => '2020-09-14 09:37:11',
                'updated_at' => '2020-09-14 09:37:11',
            ),
            1 =>
            array (
                'id' => 2,
                'booking_id' => 1,
                'room_id' => 5,
                'created_at' => '2020-09-14 09:37:11',
                'updated_at' => '2020-09-14 09:37:11',
            ),
            2 =>
            array (
                'id' => 3,
                'booking_id' => 1,
                'room_id' => 1,
                'created_at' => '2020-09-14 09:37:35',
                'updated_at' => '2020-09-14 09:37:35',
            ),
            3 =>
            array (
                'id' => 4,
                'booking_id' => 2,
                'room_id' => 10,
                'created_at' => '2020-09-14 09:58:07',
                'updated_at' => '2020-09-14 09:58:07',
            ),
            4 =>
            array (
                'id' => 5,
                'booking_id' => 3,
                'room_id' => 7,
                'created_at' => '2020-09-14 10:52:39',
                'updated_at' => '2020-09-14 10:52:39',
            ),
            5 =>
            array (
                'id' => 6,
                'booking_id' => 4,
                'room_id' => 9,
                'created_at' => '2020-09-15 09:28:48',
                'updated_at' => '2020-09-15 09:28:48',
            ),
            6 =>
            array (
                'id' => 7,
                'booking_id' => 5,
                'room_id' => 5,
                'created_at' => '2020-09-15 09:29:27',
                'updated_at' => '2020-09-15 09:29:27',
            ),
        ));


    }
}
