<?php

use Illuminate\Database\Seeder;

class TypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // factory(App\Type::class,5)->create();
        \DB::table('types')->insert(array(
            0 => array(
                'id' => 1,
                'type_name' => 'Deluxe',
                'capacity' => 5,
                'rent_price' => 600000,
                'description' => 'King bed/2 single bed, minibar, kamar mandi shower, jubah mandi, pengering rambut, TV layar datar 42 inch plus saluran kabel, meja kerja, brankas, seterika, sikat sepatu, bebas rokok',
                'created_at' => now(),
                'updated_at' => now(),
            ),
            1 => array(
                'id' => 2,
                'type_name' => 'Standar',
                'capacity' => 3,
                'rent_price' => 450000,
                'description' => 'King bed/2 single bed, minibar, kamar mandi shower, jubah mandi, pengering rambut, TV layar datar 42 inch plus saluran kabel, meja kerja, brankas, seterika, sikat sepatu, bebas rokok',
                'created_at' => now(),
                'updated_at' => now(),
            ),
            2 => array(
                'id' => 3,
                'type_name' => 'Single',
                'capacity' => 1,
                'rent_price' => 150000,
                'description' => 'King bed/2 single bed, minibar, kamar mandi shower, jubah mandi, pengering rambut, TV layar datar 42 inch plus saluran kabel, meja kerja, brankas, seterika, sikat sepatu, bebas rokok',
                'created_at' => now(),
                'updated_at' => now(),
            ),
            3 => array(
                'id' => 4,
                'type_name' => 'Twin',
                'capacity' => 2,
                'rent_price' => 300000,
                'description' => 'King bed/2 single bed, minibar, kamar mandi shower, jubah mandi, pengering rambut, TV layar datar 42 inch plus saluran kabel, meja kerja, brankas, seterika, sikat sepatu, bebas rokok',
                'created_at' => now(),
                'updated_at' => now(),
            ),
        ));

    }
}
