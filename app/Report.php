<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    
    public function user(){
        return $this->belongsTo('App\User');
    }



    public function lastEmptyReport ()
    {
        return $this->whereDoesntHave('reports', function ($q){
            return $q->wheredate('created_at', '=', Carbon::today()->toDateString());
        }); 
    }

}
