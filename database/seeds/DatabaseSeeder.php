<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UserSeeder::class);
        $this->call(TypeSeeder::class);
        $this->call(RoomsTableSeeder::class);
        // $this->call(RoomSeeder::class);
        $this->call(TenantSeeder::class);
        $this->call(BookingsTableSeeder::class);
        $this->call(BookingRoomsTableSeeder::class);
        $this->call(BookingTenantsTableSeeder::class);
        $this->call(InvoicesTableSeeder::class);
    }
}
