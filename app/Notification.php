<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = ['title', 'for', 'course_id', 'seance_id', 'user_id', 'work_id', 'test_id', 'message_id', 'context', 'seen'];
    protected $dates = ['published_at','created_at'];


    public function seances()
    {
    	return $this->belongsTo('App\Seance');
    }
}
