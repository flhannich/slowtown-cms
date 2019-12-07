<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
  protected $guarded = [];

  public function project()
  {
    return $this->belongsTo(Project::class);
  }

   public function reply()
   {
     return $this->hasMany(Comment::class, 'parent_id');
   }
}
