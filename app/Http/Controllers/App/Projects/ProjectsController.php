<?php

namespace App\Http\Controllers\App\Projects;
use App\Http\Controllers\Controller;

use App\Project;
use App\Type;
use App\Http\Resources\ProjectResources;

use Illuminate\Support\Facades\File;


class ProjectsController extends Controller
{

  public function __construct()
  {
      $this->middleware('auth');
  }

  public function show($limit)
  {
    $user = \App\User::where('id', auth()->id())->first();

    $drafts = $user->projects()
      ->with('users')
      ->with('tags')
      ->where('user_id', auth()->id())
      ->where('status', 0)
      ->orderBy('updated_at', 'desc')
      ->groupBy('id')
      ->withCount('tasks')
      ->get();

    $reviews = Project::with('users')
      ->withCount('tasks')
      ->with('tags')
      ->where('status', 1)
      ->orderBy('updated_at', 'desc')
      ->groupBy('id')
      ->withCount('tasks')
      ->get();

    $published = Project::with('users')
      ->with('tags')
      ->where('status', 2)
      ->orderBy('updated_at', 'desc')
      ->groupBy('id')
      ->limit($limit)
      ->withCount('tasks')
      ->get();

      $arr = array('drafts' => $drafts, 'reviews' => $reviews, 'published' => $published);

      return json_encode($arr);
  }

  public function create()
  {
    $slug = str_random(10);

    $attributes = ([
      'owner_id' => auth()->id(),
      'slug' => $slug,
      'status' => '0',
      'title' => 'New Draft',
      'description' => 'Your Description',
      'weight' => '0',
      'type' => '20',
      'booking' => '{}',
      'content' => ''
    ]);

    Project::create($attributes)->users()->attach(auth()->id());

    return response()->json(['slug'=> $slug]);
  }

  public function edit($slug)
  {

    $json = File::get(public_path('data/types.json'));
    $types = json_decode($json, true);

    $project = Project::where('slug', $slug)
      ->with('users')
      ->with('tasks')
      ->with('tags')
      ->get();

    if($project[0]->checkEditViewAuth($project[0], $project[0]->status))
    {
      // return ProjectResources::collection($project);
      return ['project' => $project, 'types'=> $types];

    }
    else
    {
      return response()->json(['message'=> 'You may not edit the post']);
    };
  }

  public function update(Project $project)
  {
    if($project->slugExists($project->id, request(['slug'])))
    {
      return response()->json(['message'=> 'Cannot save Project. Headline is allready taken']);
    }

    $attributes = request()->validate([
      'title' => ['required'],
      'slug' => ['required'],
      'status' => ['required'],
      'weight' => ['required']
    ]);

    $attributes += ([
      'content' => request()->content,
      'description' => request()->description,
      'booking' => request()->booking,
      'type' => request()->type
    ]);

    if($project->checkUpdateAuth($project, request()->status))
    {
      if(request()->status == 2)
      {
        // return response()->json(['message'=> 'Updated']);
        $project->update($attributes);
      }
      else
      {
        $project->update($attributes);
      }
    }
    else
    {
      return response()->json(['message'=> 'You may not update the post']);
    };
  }


  public function delete(Project $project)
  {
    if($project->checkUpdateAuth($project, $project->status))
    {
      $project->users()->detach();
      $project->delete();
    }
    else
    {
      return response()->json(['message'=> 'You may not delete the post']);
    }
  }

  public function search(Project $project, $search)
  {

    // $result = Project::where('title','LIKE',"%{$search}%")
    //     ->where('status', '=', 2)
    //     ->orderBy('created_at', 'desc')
    //     ->get();
        $user = \App\User::where('id', auth()->id())->first();

        $drafts = $user->projects()
          ->with('users')
          ->with('tags')
          ->where('title','LIKE',"%{$search}%")
          ->where('user_id', auth()->id())
          ->where('status', 0)
          ->orderBy('updated_at', 'desc')
          ->groupBy('id')
          ->get();

        $reviews = $user->projects()
          ->with('users')
          ->with('tags')
          ->where('title','LIKE',"%{$search}%")
          ->where('user_id', auth()->id())
          ->where('status', 1)
          ->orderBy('updated_at', 'desc')
          ->groupBy('id')
          ->get();

        $published = $user->projects()
          ->with('users')
          ->with('tags')
          ->where('title','LIKE',"%{$search}%")
          ->where('user_id', auth()->id())
          ->where('status', 2)
          ->orderBy('updated_at', 'desc')
          ->groupBy('id')
          ->limit(10)
          ->get();

        $arr = array('drafts' => $drafts, 'reviews' => $reviews, 'published' => $published);

        return json_encode($arr);
      }
}
