<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \Storage::makeDirectory("public/images/user");
        \Storage::makeDirectory("public/images/document");
        $data = [
            ['email' => 'rendifajri@gmail.com', 'password' => \Hash::make('123'), 'name' => 'Rendi Fajrianto', 'phone' => '085726100714', 'email_verified_at' => date('Y-m-d')]
        ];
        User::insert($data);
    }
}
