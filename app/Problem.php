<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Appoinment;
use App\Request;
use App\Auth;

class Problem extends Model
{
    //
	public function emotions()
	{
	    return $this->belongsToMany('App\Emotion')->withTimestamps();
	}

  public function diagnosis(){
    return $this->belongsTo('App\Diagnosis');
  }

  public function appointments(){
    return $this->belongsToMany('App\Appointment');
  }


	public function describable(){
		return $this->morphTo();
	}

  //self join
  public function parent_problem(){
      return $this->hasMany(self::class, 'parentproblem_id', 'id');
  }

  public function children_problem(){
    return $this->belongsTo(self::class, 'id', 'parentproblem_id' )->with('children_problem');
  }

  public function start_parent_problem(Appointment $appointment_id)	{
    $problem = null;
    if(Problem::where('cleared', false)
            ->whereHas('appointments', function($query) use($appointment_id){
                $query->where('appointment_id', '=', $appointment_id);
            })
            ->count()>0){

                $problem =Problem::where('cleared', false)
                  ->whereHas('appointments', function($query) use($appointment_id){
                    $query->where('appointment_id', '=', $appointment_id);
                  })->latest()->first();
    }
    return $problem;
  }

  public function count_heartwalls($appointment_id){
     $count = Problem::whereHas('appointments', function($subquery) use($appointment_id){
                $subquery->where('appointment_id', '=', $appointment_id);
            })
          ->where('describable_type', 'App\Heartwall')
          ->where ('cleared', false)
          ->count();
      return $count;
  }     
}