<?php

use Illuminate\Database\Seeder;

class RoomsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('rooms')->delete();
        
        \DB::table('rooms')->insert(array (
            0 => 
            array (
                'id' => 1,
                'type_id' => 3,
                'no_room' => '12',
                'status' => 'available',
                'created_at' => '2020-09-18 09:50:07',
                'updated_at' => '2020-09-18 09:50:07',
            ),
            1 => 
            array (
                'id' => 2,
                'type_id' => 3,
                'no_room' => '2',
                'status' => 'maintenance',
                'created_at' => '2020-09-18 09:50:07',
                'updated_at' => '2020-09-18 09:50:07',
            ),
            2 => 
            array (
                'id' => 3,
                'type_id' => 3,
                'no_room' => '10',
                'status' => 'available',
                'created_at' => '2020-09-18 09:50:07',
                'updated_at' => '2020-09-18 09:56:15',
            ),
            3 => 
            array (
                'id' => 4,
                'type_id' => 2,
                'no_room' => '4',
                'status' => 'maintenance',
                'created_at' => '2020-09-18 09:50:07',
                'updated_at' => '2020-09-18 09:50:07',
            ),
            4 => 
            array (
                'id' => 5,
                'type_id' => 3,
                'no_room' => '9',
                'status' => 'maintenance',
                'created_at' => '2020-09-18 09:50:07',
                'updated_at' => '2020-09-18 09:50:07',
            ),
            5 => 
            array (
                'id' => 6,
                'type_id' => 2,
                'no_room' => '6',
                'status' => 'available',
                'created_at' => '2020-09-18 09:50:07',
                'updated_at' => '2020-09-18 09:50:07',
            ),
            6 => 
            array (
                'id' => 7,
                'type_id' => 1,
                'no_room' => '4',
                'status' => 'booked',
                'created_at' => '2020-09-18 09:50:07',
                'updated_at' => '2020-09-18 09:52:34',
            ),
            7 => 
            array (
                'id' => 8,
                'type_id' => 4,
                'no_room' => '3',
                'status' => 'available',
                'created_at' => '2020-09-18 09:50:07',
                'updated_at' => '2020-09-18 09:50:07',
            ),
            8 => 
            array (
                'id' => 9,
                'type_id' => 1,
                'no_room' => '1',
                'status' => 'available',
                'created_at' => '2020-09-18 09:50:07',
                'updated_at' => '2020-09-18 09:56:07',
            ),
            9 => 
            array (
                'id' => 10,
                'type_id' => 3,
                'no_room' => '8',
                'status' => 'maintenance',
                'created_at' => '2020-09-18 09:50:07',
                'updated_at' => '2020-09-18 09:50:07',
            ),
        ));
        
        
    }
}