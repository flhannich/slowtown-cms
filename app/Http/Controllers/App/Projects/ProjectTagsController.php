<?php

namespace App\Http\Controllers\App\Projects;
use App\Http\Controllers\Controller;

use App\Tag;
use App\Project;
use Illuminate\Http\Request;

class ProjectTagsController extends Controller
{
  public function __construct()
  {
      $this->middleware('auth');
  }

    public function store(Project $project)
    {
      $attributes = request()->validate(['name' => 'required']);

      $project->addTag($attributes);
    }


    public function delete(Project $project, Tag $tag)
    {
      $project->removeTag($tag);

      if(Tag::emptyRelation($tag)) {
        $tag->delete();
      }
    }

    public function search(Tag $tag, $query)
    {
      // $result = Tag::where('name','LIKE',"%{$query}%")->limit(5)->get();

      $result = Tag::whereHas('project', function ($q) {
          $q->where('status', 2);
      })
        ->where('name','LIKE',"%{$query}%")
        ->get();

      return response()->json(['query'=> $result]);
    }
}
