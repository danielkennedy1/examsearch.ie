<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i = 0; $i<1000; $i++){
            error_log($i);

            $faker = \Faker\Factory::create();

            DB::table("mycomments")->insert([
                "user_id" => rand(10, 500),
                "discussion_id" => rand(1, 2826),
                "comment" => $faker->sentence,
                "approved" => 0,
                "created_at" => now(),
                "updated_at" => now()
            ]);
        }
    }
}
