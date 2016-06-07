<?php

use Illuminate\Database\Seeder;
use Faker\Generator;
class ReportsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('reports')->delete();

        $users = \App\User::all();;
        $faker = Faker\Factory::create();
        foreach ($users as $users){
        for ($i=1; $i<7; $i++){
            if($i == 1){
                $time = \Carbon\Carbon::parse('today');
            }else{
                $time = \Carbon\Carbon::parse('-'.$i.' days');
            }
            $report = \App\Report::create([
                'user_id' => $users->id,
                'task_done' => $faker->text(250),
                'created_at'    => $time
            ]);
            }

        }

    }
}
