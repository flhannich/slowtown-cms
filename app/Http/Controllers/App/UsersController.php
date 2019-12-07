<?php

namespace App\Http\Controllers\App;

use App\User;
use App\Upload;
use \Auth;

use App\Http\Resources\UsersResources;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;

use App\Http\Controllers\Controller;

class UsersController extends Controller
{
  public function __construct()
   {
       $this->middleware('auth');
   }

    public function show()
    {
      $user = User::orderBy('name', 'asc')->get();

      return UsersResources::collection($user);
    }

    public function update(User $user)
    {
      $attributes = request()->validate([
        'role_id' => ['required']
      ]);

      $user->update($attributes);

      return response()->json(['message'=> 'User role updated']);
    }


    public function delete(Upload $upload, User $user)
    {
      if($user->role_id !== 1)
      {
        if($user->projects()->where('status', 2)->first() !== null)
        {
          return response()->json(['message'=> 'Cannot delete. User got published posts.']);
        }
        else
        {
          if($user->image != null) {
            $upload->deleteImage(array('image' => $user->image));
          }
          $user->projects()->where('status', 0)->delete();
          $user->projects()->where('status', 1)->delete();
          $user->delete();
          return response()->json(['message'=> 'User deleted']);
        }
      }
    }
}
