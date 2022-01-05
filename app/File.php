<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    protected $fillable = ['title', 'filename', 'type', 'size', 'from'];

    public function notifications()
    {
        return $this->hasMany('App\Notification');
    }

    public function backpacks()
    {
        return $this->belongsToMany('App\Backpack');
    }

    public function works()
    {
        return $this->belongsToMany('App\Work');
    }

    public function tests()
    {
        return $this->belongsToMany('App\Test');
    }
}
