<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $guarded = [];

    public function project()
    {
      return $this->belongsTo(Project::class);
    }

    public function user()
    {
      return $this->belongsTo(User::class);
    }

     public function reply()
     {
       return $this->hasMany(Task::class, 'parent_id')->with('user');
     }

}
