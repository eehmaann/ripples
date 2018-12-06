<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    public function goals(){
        return $this->hasMany('App\Goal');
    }

    public function appointment()
    {
        return $this->hasMany('App\Appointment');
    }

     public function lastPublished(){
      $appointment = $this->appointment()
            ->where('published', true)
            ->latest()->first();

        return $appointment;
  } 
}


