<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class RegularUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
         User::create([
            'name' => 'Geethu',
            'email' => 'geethu@expenseapp.com',
            'password' => Hash::make('geethu123'),
            'is_admin' => false,
            'email_verified_at' => Carbon::now(),
        ]);

        User::create([
            'name' => 'Test',
            'email' => 'test@expenseapp.com',
            'password' => Hash::make('test123'),
            'is_admin' => false,
            'email_verified_at' => Carbon::now(),
        ]);
    }
}
