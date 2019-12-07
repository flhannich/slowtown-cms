<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $guarded = [];

    public function project()
    {
      return $this->belongsToMany(Project::class);
    }

    static public function emptyRelation($tag) {
      $count = Project::whereHas('tags')
        ->join('project_tag', 'tag_id', '=', $tag->id)
        ->groupBy('projects.id')
        ->count();

        if($count == 0) {
          return true;
        }
    }

}
