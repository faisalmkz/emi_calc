<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (!User::where('email', "developer@tuna.com")->exists()) {
            $user = new User();
            $user->name = "developer";
            $user->email = "developer@tuna.com";
            $user->password = bcrypt('Test@Tuna123#'); ;
            $user->created_at = Carbon::now();
            $user->save();
        }
    }
}
