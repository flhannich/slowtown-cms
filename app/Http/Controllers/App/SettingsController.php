<?php

namespace App\Http\Controllers\App;

use App\User;
use App\Setting;
use App\Type;
use App\Project;

use App\Http\Resources\SettingsResources;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;


class SettingsController extends Controller
{
  public function __construct()
  {
      $this->middleware('auth');
  }

    public function show()
    {
      if(Setting::checkUpdateAuth()) {
        $result = Setting::all();
        return SettingsResources::collection($result);
      }
    }

    public function update(Setting $setting)
    {
      if(Setting::checkUpdateAuth())
      {
        $attributes = request()->validate([
          'url' => ['required'],
          'title' => ['required'],
          'email' => ['required']
        ]);
        $attributes += request([
          'description',
          'subtitle',
          'owner',
          'phone',
          'street',
          'city',
          'post',
          'country',
          'social',
          'facebook',
          'instagram',
          'twitter',
          'youtube',
          'linkedin',
          'xing'
        ]);

       $setting->update($attributes);
       return response()->json(['message'=> 'Saved']);
      }
    }

}
