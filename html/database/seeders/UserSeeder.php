<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i=1; $i<=500; $i++) {
            $faker = \Faker\Factory::create();

            DB::table("users")->insert([
                "name" => $faker->name(),
                "email" => $faker->safeEmail(),
                "password" => Hash::make("password"),
                "created_at" => now(),
                "updated_at" => now()
            ]);
        }
    }
}
