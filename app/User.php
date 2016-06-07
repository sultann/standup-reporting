<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','teams', 'role'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function allTeams(){
        return Team::all();
    }

    public function reports(){
        return $this->hasMany(Report::class)->orderBy('created_at', 'desc');
    }
    
    public function teams(){
        return $this->belongsToMany(Team::class);
    }
    public function blockers(){
        return $this->hasMany(Blocker::class);
    }

    public function openBlockers(){
        return $this->hasMany(Blocker::class)->where('status', '=', 1)->orderBy('created_at', 'desc');
    }

    public function lastReport ()
    {
        return $this->hasMany(Report::class)->wheredate('created_at', '<', Carbon::today()->toDateString())->orderBy('created_at', 'desc')->take(1);
    }
    public function todaysReport ()
    {
        return $this->hasMany(Report::class)->wheredate('created_at', '=', Carbon::today()->toDateString())->take(1);
    }
    public function lastEmptyReport ()
    {
        return $this->whereDoesntHave('reports', function ($q){
            return $q->wheredate('created_at', '=', Carbon::today()->toDateString());
        }); // Order it by anything you want
    }
    
}
