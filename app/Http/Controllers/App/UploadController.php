<?php

namespace App\Http\Controllers\App;

use App\Project;
use App\User;
use App\Upload;
use App\Setting;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\File;

use App\Http\Controllers\Controller;

class UploadController extends Controller
{

  public function editorVideo(Upload $upload)
  {
    // $validate = request()->validate([
    //     'image' => 'mimes:jpeg,jpg,png,gif'
    //  ]);
    // if($validate)
    // {
      $result = $upload->video(request()->file('video'));
      return response()->json($result);
    // }
    return response()->json(['message'=> 'Something is wrong about your video']);
  }

public function editorVideoDelete(Upload $upload) {

    $video = request(['video']);
    $result = $upload->deleteVideo($video);

    if($result)
    {
      return response()->json(['message' => 'Video deleted']);
    }
    return response()->json(['message'=> 'Couldnt delete Video']);
}






  public function editorImage(Upload $upload)
  {
    $validate = request()->validate([
        'image' => 'mimes:jpeg,jpg,png,gif'
     ]);
    if($validate)
    {
      $result = $upload->image(request()->file('image'));
      return response()->json($result);
    }
    return response()->json(['message'=> 'Something is wrong about your image']);
  }

public function editorImageDelete(Upload $upload) {

    $image = request(['image']);
    $result = $upload->deleteEditorImage($image);

    if($result)
    {
      return response()->json(['message' => 'Image deleted']);
    }
    return response()->json(['message'=> 'Couldnt delete Image']);
}




  public function project(Upload $upload, Project $project)
  {
      $validate = request()->validate([
        'image' => 'mimes:jpeg,jpg,png,gif'
       ]);
      if($validate)
      {
        $result = $upload->image(request()->file('image'));
        $project->update(['image' => $result]);
        return response()->json($result);
      }
      return response()->json(['message'=> 'Something is wrong about your image']);
  }

  public function projectDelete(Upload $upload, Project $project)
  {
    $image = request(['image']);
    $result = $upload->deleteImage($image);

    if($result)
    {
      $project->update(['image' => null]);
      return response()->json(['message' => 'Image deleted']);
    }
    return response()->json(['message'=> 'Couldnt delete Image']);
  }

   public function profile(Upload $upload, User $user)
   {
     $validate = request()->validate([
       'image' => 'mimes:jpeg,jpg,png,gif'
      ]);
     if($validate)
     {
       $result = $upload->image(request()->file('image'));
       $user->update(['image' => $result]);
       return response()->json($result);
     }
     return response()->json(['message'=> 'Something is wrong about your image']);
  }

   public function profileDelete(Upload $upload, User $user)
   {
     $image = request(['image']);
     $result = $upload->deleteImage($image);

     if($result)
     {
       $user->update(['image' => null]);
       return response()->json(['message' => 'Image deleted']);
     }
     return response()->json(['message'=> 'Couldnt delete Image']);
  }

   public function favicon(Upload $upload, Setting $setting)
   {
     $validate = request()->validate([
       'image' => 'mimes:svg,jpeg,jpg,png,gif'
      ]);
     if($validate)
     {
       $result = $upload->favicon(request()->file('image'));
       $setting->update(['favicon' => $result]);
       return response()->json($result);
     }
     else
     {
       return response()->json(['message'=> 'Something is wrong about your image']);
     }
  }

  public function faviconDelete(Upload $upload, Setting $setting)
  {
    $image = request(['image']);
    $result = $upload->deleteFavicon($image);

    if($result)
    {
      $setting->update(['favicon' => null]);
      return response()->json(['message' => 'Favicon deleted']);
    }
    return response()->json(['message'=> 'Couldnt delete Favicon']);
 }


   public function logo(Upload $upload, Setting $setting)
   {
     $validate = request()->validate([
       'image' => 'mimes:svg,jpeg,jpg,png,gif'
      ]);
     if($validate)
     {
       $result = $upload->image(request()->file('image'));
       $upload->favicon(request()->file('image'));
       $setting->update(['image' => $result]);
       return response()->json($result);
     }
     return response()->json(['message'=> 'Something is wrong about your image']);
  }

   public function logoDelete(Upload $upload, Setting $setting)
   {
     $image = request(['image']);
     $result = $upload->deleteImage($image);

     if($result)
     {
       $setting->update(['image' => null]);
       return response()->json(['message' => 'Image deleted']);
     }
     return response()->json(['message'=> 'Couldnt delete Image']);
  }


}
