<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         $this->call([
             UserSeeder::class,
             TaskSeeder::class
         ]);
         DB::table('users')->where('id', '>' , 1)->update(['role' => 0]);
         DB::table('users')->update(['manager_id' => 1]);
         DB::table('tasks')->update(['creator_id' => 1]);
    }
}
