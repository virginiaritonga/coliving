<?php

use Carbon\Traits\Timestamp;
use Illuminate\Database\Seeder;

class TenantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // factory(App\Tenant::class,5)->create();
        \DB::table('tenants')->insert(array(
            0 => array(
                'id' => 1,
                'tenant_name' => 'Agus Setiawan',
                'email' => 'agus@gmail.com',
                'IDcard_number' => '3206711234543567',
                'type_IDcard' => 'KTP',
                'no_HP' => '081123564787',
                'address' => 'Ds. Bass No. 302, Tangerang 20866, Bali',
                'status' => 'inactive',
                'created_at' => now(),
                'updated_at' => now(),
            ),
            1 => array(
                'id' => 2,
                'tenant_name' => 'Ardi Susanto',
                'email' => 'ardi@gmail.com',
                'IDcard_number' => 'A206711',
                'type_IDcard' => 'Passport',
                'no_HP' => '081123564087',
                'address' => 'Psr. Teuku Umar No. 459, Sorong 26925, SumBar',
                'status' => 'inactive',
                'created_at' => now(),
                'updated_at' => now(),
            ),
            2 => array(
                'id' => 3,
                'tenant_name' => 'Lukita Ajimat Siregar S.Psi',
                'email' => 'lukita@gmail.com',
                'IDcard_number' => 'B206711',
                'type_IDcard' => 'Passport',
                'no_HP' => '081129564087',
                'address' => 'Jln. Raden No. 472, Padang 34794, KalSel',
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ),
            3 => array(
                'id' => 4,
                'tenant_name' => 'Elisa Winda Hariyah',
                'email' => 'elisa@gmail.com',
                'IDcard_number' => '3206721234543554',
                'type_IDcard' => 'KTP',
                'no_HP' => '081129564086',
                'address' => 'Gg. Panjaitan No. 715, Malang 62967, KepR',
                'status' => 'inactive',
                'created_at' => now(),
                'updated_at' => now(),
            ),
            4 => array(
                'id' => 5,
                'tenant_name' => 'Kayla Puspita S.H.',
                'email' => 'kayla@gmail.com',
                'IDcard_number' => '320672123451',
                'type_IDcard' => 'SIM',
                'no_HP' => '081119564086',
                'address' => 'Kpg. Ki Hajar Dewantara No. 375, Cimahi 62941, Lampung',
                'status' => 'inactive',
                'created_at' => now(),
                'updated_at' => now(),
            ),
        ));

    }
}
