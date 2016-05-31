<?php

use Illuminate\Database\Seeder;

class TeamUser extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        // following line retrieve all the user_ids from DB
        $users = User::all()->lists('id');
        foreach(range(1,50) as $index){
            $company = Company::create([
                'name' => $faker->company,
                'user_id' => $faker->randomElement($users),
            ]);
        }
    }
}
