<?php

namespace App\Http\Controllers\App\Projects;
use App\Http\Controllers\Controller;

use App\User;
use App\Project;
use Illuminate\Http\Request;
use App\Http\Resources\ProjectResources;

class ProjectUsersController extends Controller
{
  public function __construct()
  {
      $this->middleware('auth');
  }

  public function show(Project $project) {

    $user = User::all();

    return ProjectResources::collection($user);
  }

  public function store(Project $project)
  {
    $userId = request()->validate([
      'user_id' => ['required'],
    ]);
    $user = User::find($userId);

    $project->addUser($user);
  }

  public function delete(Project $project, User $user)
  {
      $project->removeUser($user);
  }

  public function search(User $user, $query)
  {
    $result = User::where('name','LIKE',"%{$query}%")->limit(5)->get();

    return response()->json(['query'=> $result]);
  }
}
