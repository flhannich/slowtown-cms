<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $guarded = [];

    public static function checkUpdateAuth()
    {
      $user = \App\User::where('id', auth()->id())->first();

      if($user->role->id == 1 || $user->role->id == 2)
      {
        return true;
      }
      else
      {
        return false;
      }
    }

}
