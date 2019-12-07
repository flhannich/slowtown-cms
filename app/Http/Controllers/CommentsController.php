<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;

use App\Comment;
use App\Project;
use App\Mail\NewCommentCreated;
use App\Http\Resources\CommentResources;

use Illuminate\Http\Request;

class CommentsController extends Controller
{
  // public function __construct()
  // {
  //     $this->middleware('auth');
  // }

    public function show($slug)
    {
      $project = Project::where('slug', $slug)->first();

      $comments = Comment::where('project_id', $project->id)
        ->where('parent_id', '=', null)
        ->with('reply')
        ->orderBy('created_at', 'desc')
        ->get();

      return CommentResources::collection($comments);
    }

    public function store(Project $project) {

      $attributes = request()->validate([
        'content' => ['required'],
        'author' => ['required']
      ]);

      $project->addComment($attributes);

      \Mail::to('think@web123.de')->send(
        new newCommentCreated($attributes, $project)
      );
      return response()->json(['message'=> 'Success']);
    }

    public function reply(Project $project, $parent)
    {
      $attributes = request()->validate([
        'content' => ['required'],
        'author' => ['required']
      ]);

      $attributes['parent_id'] = $parent;

      $project->addComment($attributes);

      \Mail::to('think@web123.de')->send(
        new newCommentCreated($attributes, $project)
      );
      return response()->json(['message'=> 'Success']);
    }

    public function approve(Comment $comment)
    {
        $attributes = request()->validate([
          'approved' => ['required'],
        ]);

        $comment->update($attributes);
    }

    public function like(Comment $comment)
    {

        $result = Comment::select('like')->where('id', $comment->id)->first();
        if($result->like == null) {
          $insert = 1;
        }
        else {
          $insert = $result->like + 1;
        }

        var_dump($insert);
        $attributes['like'] = $insert;

        $comment->update($attributes);
    }





    public function delete(Comment $comment) {

      $task->reply()->delete();
      $task->delete();

    }
}
