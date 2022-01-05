<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Backpack extends Model
{
    protected $fillable = ['teacher_id'];

    public function notifications()
    {
        return $this->hasMany('App\Notification');
    }

    public function files()
    {
        return $this->belongsToMany('App\File');
    }
}
