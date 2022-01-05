<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
    protected $fillable = ['seance_id', 'title', 'file', 'description'];

    public function seance() 
    {
    	return $this->belongsTo('App\Seance');
    }

    public function files()
    {
        return $this->belongsToMany('App\File');
    }
}
