<?php

namespace App\Http\Controllers\App;

use App\Role;
use App\User;
use \Auth;

use App\Http\Resources\ProfileResources;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
  public function __construct()
  {
      $this->middleware('auth');
  }

    public function show()
    {
      $profile = User::where('id', auth()->id())->with('role')->get();

      return new ProfileResources($profile);
    }

    public function update(User $user)
    {
      $attributes = request()->validate([
        'name' => ['unique:users,name,'. $user->id .''],
        'email' => ['unique:users,email,'. $user->id .''],
        'description' => ['required']
      ]);
       $attributes += request([
         'social',
         'facebook',
         'instagram',
         'twitter',
         'youtube',
         'linkedin',
         'xing'
       ]);
      $user->update($attributes);

      return response()->json(['message'=> 'Saved']);
    }

    public function password(User $user)
    {
      $attriburtes = request()->validate([
        'password' => 'required|confirmed|min:1',
      ]);

      $credentials = request()->only(
         'password', 'password_confirmation', 'old_password'
      );

      if (Hash::check($credentials['old_password'], $user->password))
      {
        $user->password = bcrypt($credentials['password']);

        $user->save();

        return response()->json(['message'=> 'Password changed']);
      }
      // return back();
      return response()->json(['message'=> 'Something went wrong. Try again.']);
    }
}
