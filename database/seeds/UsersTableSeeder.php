<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->delete();
        $faker = Faker\Factory::create();
        for ($i = 0; $i < 80; $i++) {
            $user = \App\User::create(
                [
                    'name' => $faker->name,
                    'email' => $faker->safeEmail,
                    'password' => bcrypt('123456'),
                    'remember_token' => str_random(10),
                ]
            );
            $user->teams()->sync([$faker->numberBetween(1,11), $faker->numberBetween(1,11)]);
        }

    }
}
