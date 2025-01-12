<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
       //  \App\Models\User::factory()->has(\App\Models\Cliente::factory(1),'cliente')->count(50)->create();
      User::where('email', 'miguelsapalomiguel17@gmail.com')->update(['password' => Hash::make('123456789')]);
    }
}
