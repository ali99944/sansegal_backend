<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Manager;
use Illuminate\Support\Facades\Hash;

class ManagerSeeder extends Seeder
{
    public function run(): void
    {
        if (!Manager::where('email', 'admin@sansegal.com')->exists()) {
            Manager::create([
                'name' => 'Admin',
                'email' => 'admin@sansegal.com',
                'password' => Hash::make('password'), // Use a secure password in production!
            ]);
        }
    }
}
