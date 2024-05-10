<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class DatabaseSeeder extends Seeder
{
        /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Seed the users table
        $this->seedUsers();

        // Seed the post_message table
        $this->seedPostMessages();
    }

    private function seedUsers()
    {
        $faker = Faker::create();

        for ($i = 0; $i < 10; $i++) {
            DB::table('users')->insert([
                'name' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'password' => bcrypt('secret'),
            ]);
        }
    }

    private function seedPostMessages()
    {
        $faker = Faker::create();
        $userIds = DB::table('users')->pluck('id');

        for ($i = 0; $i < 10; $i++) {
            $userId = $faker->randomElement($userIds);
            DB::table('post_message')->insert([
                'id_users' => $userId,
                'text' => $faker->paragraph,
                'nb_comment' => 0,
                'nb_like' => 0,
                'id_referencecomment' => null,
                'created_at' => $faker->dateTimeThisMonth,
            ]);
        }
    }
}
