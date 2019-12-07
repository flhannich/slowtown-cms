<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $guarded = [];

    public function unsignedUser($projectId)
    {
      return User::whereDoesntHave('projects', function ($query) use($projectId) {
         $query->whereId($projectId);
      })->get();
    }

    public function tasks()
    {
      return $this->hasMany(Task::class);
    }

    public function addTask($task)
    {
        $this->tasks()->create($task);
    }

    public function comments()
    {
      return $this->hasMany(Comment::class);
    }

    public function addComment($comment)
    {
        $this->comments()->create($comment);
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function addUser($users)
    {
      $this->users()->attach($users);
    }

    public function removeUser($user)
    {
      $this->users()->detach($user);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function addTag($tag)
    {
      $id = Tag::select('id')->where('name', $tag['name'])->first();
       if($id)
       {
         $this->tags()->attach($id);
       }
       else
       {
         $this->tags()->create($tag);
       }
    }

    public function removeTag($tag)
    {
      $this->tags()->detach($tag);
    }

    public function checkUpdateAuth($project, $status)
    {
      $user = \App\User::where('id', auth()->id())->with('role')->first();
      $isAuthor = $project->users->contains(auth()->id());
      var_dump($project->users);
      if($status == 2)
      {
        if($user->role->id == 1 || $user->role->id == 2 || $isAuthor)
        {
          return true;
        }
        else
        {
          return false;
        }
      }
      if($status == 0 || $status == 1 )
      {
        if($isAuthor) {
          return true;
        }
        else
        {
          return false;
        }
      }
    }

    public function checkEditViewAuth($project, $status)
    {
      $user = \App\User::where('id', auth()->id())->with('role')->first();
      $isAuthor = $project->users->contains(auth()->id());

      if($status == 2)
      {
        return true;
      }
      if($status == 1)
      {
        return true;
      }
      if($status == 0)
      {
        if($isAuthor) {
          return true;
        }
        else
        {
          return false;
        }
      }
  }

  public function slugExists($id, $slug)
  {
    $check = \App\Project::where('slug', $slug)->first();
    if($check && $check->id != $id) {
      return true;
    }
  }
}
