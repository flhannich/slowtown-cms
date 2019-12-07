<?php

namespace App\Http\Controllers\App\Projects;
use App\Http\Controllers\Controller;

use App\Task;
use App\Project;
use App\Mail\ForeignTaskCreated;
use App\Http\Resources\TaskResources;


class ProjectTasksController extends Controller
{
  public function __construct()
  {
      $this->middleware('auth');
  }

    public function show($slug)
    {
      $project = Project::where('slug', $slug)->first();

      $tasks = Task::where('project_id', $project->id)
        ->with('user')
        ->with('reply')
        ->with('user')
        ->orderBy('created_at', 'desc')
        ->get();

      return TaskResources::collection($tasks);
    }

    public function store(Project $project) {

      $attributes = request()->validate([
        'description' => 'required',
      ]);

      $attributes['user_id'] = auth()->id();

      $project->addTask($attributes);

      \Mail::to('think@web123.de')->send(
        new ForeignTaskCreated($attributes, $project)
      );
      //return back();
    }


    public function update(Task $task) {

        $attributes = request()->validate([
          'description' => ['required'],
          'completed' => ['required'],
        ]);

        $task->update($attributes);
    }


    public function reply(Project $project, $parent) {

      $attributes = request()->validate([
        'description' => ['required']
      ]);

      $attributes['parent_id'] = $parent;

      $attributes['user_id'] = auth()->id();

      $project->addTask($attributes);

    //   $task->taskReply($attributes);
       return response()->json(['message'=> 'Success']);

    }


    public function delete(Task $task) {

      $task->reply()->delete();
      $task->delete();

    }

}
