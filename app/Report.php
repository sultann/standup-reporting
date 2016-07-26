<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Report extends Model
{
    
    use SoftDeletes;
    
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];
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
