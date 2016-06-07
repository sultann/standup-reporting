<?php

use Illuminate\Database\Seeder;

class BlockerTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('blockers')->delete();
        factory('App\Blocker', 50)->create();
    }
}
