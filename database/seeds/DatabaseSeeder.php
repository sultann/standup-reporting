<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//        $this->call(UsersTableSeeder::class);
//        $this->call(TeamsTableSeeder::class);
        $this->call(ReportsTableSeeder::class);
//        $this->call(TeamUser::class);
//        $this->call(BlockerTableSeeder::class);
    }
}
