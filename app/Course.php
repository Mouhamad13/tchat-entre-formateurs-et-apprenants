<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class Course extends Model
{

	protected $fillable = ['teacher_id', 'access_token', 'title', 'group', 'school', 'place', 'access'];

	public function users()
	{
	    return $this->belongsToMany('App\User')->withPivot('access');
	}

	public function seances()
	{
		return $this->hasMany('App\Seance');
	}

	public function notifications()
	{
		return $this->hasMany('App\Notification');
	}
}
