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
        'Web Designer',
        'Front End Developer',
        'UI Designer',
        'UX Designer',
        'Interaction Designer',
        'Art Director',
        'Web Developer',
        'Full Stack Developer',
        'Content Strategist',
        'IT Technician',
        'Dev Ops',
        'Product Manager',
        'Customer Service Representative',
        'SEO Specialist'
    );
    public function run()
    {
        DB::table('teams')->delete();


        foreach ($this->teams as $team){
            \App\Team::insert(['team_name' => $team]);
        }
    }
}
