<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class Seance extends Model
{
    protected $fillable = ['course_id', 'classroom_id', 'start_hours', 'end_hours', 'absent', 'local'];
    protected $dates = ['published_at','created_at','start_hours','end_hours'];

    public function course() 
    {
    	return $this->belongsTo('App\Course');
    }

    public function works()
	{
		return $this->hasMany('App\Work');
	}

	public function notifications()
	{
		return $this->hasMany ('App\Notification');
	}
	
	public function tests()
	{
		return $this->hasMany('App\Test');
	}
}
