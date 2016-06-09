<?php

use Illuminate\Database\Seeder;
class TeamsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    protected $teams = array(
        'Admin',
        'Scrum Team & Documentation Team',
        'Dev Team',
        'DevOps/SecOps Team',
        'Android & iOS Team',
        'QA Team',
        'Game Team',
        'Frontend Team',
        'Design Team',
        'Business Team and Content Writer Team',
        'Admin & HR'
    );
    public function run()
    {
        DB::table('teams')->delete();


        foreach ($this->teams as $team){
            \App\Team::insert(['team_name' => $team]);
        }
    }
}
