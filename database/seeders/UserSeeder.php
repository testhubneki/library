<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\UserRole;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        try 
        {
            \DB::beginTransaction();
            $user = User::create([
                'name' =>'librarian',
                'email' => 'admin@mail.com',
                'password' => bcrypt('1234567')
            ]);

            $id = $user->id;

            UserRole::create([
                'user_id' => $id,
                'role_id'=>1
            ]);

            \DB::commit();
        } catch (\Exception $e){
            \DB::rollBack();
            \Log::info($e->getMessage());
        }
    }
}
