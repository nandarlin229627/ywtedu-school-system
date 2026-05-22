<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('rooms')->insert([

            [
                'room_name' => 'Room 101',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'room_name' => 'Room 102',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'room_name' => 'Lab A',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'room_name' => 'Hall 1',
                'created_at' => now(),
                'updated_at' => now(),
            ],

        ]);
    }
}