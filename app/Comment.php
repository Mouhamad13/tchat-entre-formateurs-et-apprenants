<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = ['body', 'from', 'for', 'context'];

    public function notifications()
    {
        return $this->hasMany('App\Notification');
    }
}
