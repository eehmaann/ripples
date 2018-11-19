<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Goal;
use App\Appointment;
use App\User;
use App\Diagnosis;
use App\Locator;
use App\Problem;
use App\Solution;
use Redirect;
use DB;

class AppointmentController extends Controller
{
    //
    public function create(){
    	return View('navigation.practitionerstart')
    		->with('users',User::orderBy('name')->get());
    }

    public function storeAppointment(Request $request){
    	$this->validate($request, [
    		'goal_id'=> 'required|numeric',
    	]);

        $goal_id= $request->input('goal_id');
        $priorAppointment=Appointment::where('goal_id', $goal_id)->with('problems')->latest()->first();
        $problemlist=$priorAppointment->problems()->where('cleared', false)->get();


    	$appointment =new Appointment();
    	$appointment->goal_id=$goal_id;
    	$appointment->save();
        
        
        $appointment->problems()->sync($problemlist);

    	return \Redirect::route('navigation.show', $appointment);
    }

    public function storeGoalAppointment(Request $request){
    	$this->validate($request, [
    		'user_id'=> 'required|numeric',
    		'case_description'=>'required|min:5',
    		'goal_description'=>'required|min:10',
    	]);
    	$goal= new Goal();
    	$goal->user_id=$request->input('user_id');
    	$goal->reason=$request->input('case_description');
    	$goal->goal=$request->input('goal_description');
    	$goal->save();
    	
    	$goal_match =Goal::latest()->first();
    	$appointment =new Appointment();
    	$appointment->goal_id=$goal_match->id;
    	$appointment->save();
    	return \Redirect::route('navigation.show', $appointment);


    }

    public function storeUserGoalAppointment(Request $request){
    	$this->validate($request, [
    		'client_name'=> 'required|min:5',
    		'client_email'=>'required|email',
    		'case_description'=>'required|min:5',
    		'goal_description'=>'required|min:10',
    	]);
      
    	$user= new User();
    	$user->name=$request->input('client_name');
    	$user->email=$request->input('client_email');
    	$user->password='password';
        auth()->login($user);
    	$user->save();
    
    // Create case
    	$user_id =User::latest()->first();
    	$goal= new Goal();
    	$goal->reason=$request->input('case_description');
    	$goal->goal=$request->input('goal_description');
    	$goal->user_id=$user_id->id;
    	$goal->save();

    	$goal_match =Goal::latest()->first();
    	$appointment =new Appointment();
    	$appointment->goal_id=$goal_match->id;
    	$appointment->save();
    	return \Redirect::route('navigation.show', $appointment);
    }

    public function publishAppointment($id){
        $appointment = Appointment::find($id);
        $appointment->showable=true;
        $appointment->save();

        return redirect('/sessionstart');
    }

    public function saveAppointment(){
        return redirect('/sessionstart');
    }

    public function showAppointment ($id){
        $appointment=Appointment::find($id);

        $problems = [];
        $problems[]=$appointment->problems;


        $solutions=[];
        $solutions=$appointment->solution;
    
         return view('reports')
            ->with(['problems'=>$problems,
                    'appointment'=>$appointment,
                    'solutions'=>$solutions]);
    }

    public function showLastAppointment(Request $request){
        $user=$request->user();
        $appointment= $user->appointment->latest()->first();
        showAppointment($appointment->id);
    }
}
