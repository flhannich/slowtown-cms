<?php

namespace App;

use Image;

use Illuminate\Support\Facades\File;

use Illuminate\Database\Eloquent\Model;

class Upload extends Model
{

    function video($file)
    {
        // var_dump(request()->file('video'));
        $path = '/video/' . date('Y') . '/' . date('m') . '/' . date('d') . '/';

        File::makeDirectory(public_path($path), $mode = 0777, true, true);

        $name = uniqid() . '.ogg';

        $file = request()->file('video');
        // // $ext = $file->getClientOriginalExtension();
        //
        $file->move(public_path($path), $name);
        //
        $result = $path . $name;
        //
        return json_encode($result);
    }

    function deleteVideo($video)
    {
      $file = json_decode($video['video']);

      File::delete(public_path($file));

      return true;
    }


    function image($file)
    {
        $path = '/img/' . date('Y') . '/' . date('m') . '/' . date('d') . '/';

        File::makeDirectory(public_path($path), $mode = 0777, true, true);

        $file = request()->file('image');
        // $ext = $file->getClientOriginalExtension();
        $name = uniqid();

        $variations = json_decode('[
        {
          "title": "small",
          "size": "350"
        },
        {
          "title": "medium",
          "size": "768"
        },
        {
          "title": "large",
          "size": "1280"
        },
        {
          "title": "full",
          "size": "1920"
        }
        ]');
        $result = array();
        foreach ($variations as $key => $var ) {
          Image::make($file->getRealPath())->resize($var->size,$var->size, function($constraint){
            $constraint->aspectRatio();
            $constraint->upsize();
          })->save(public_path($path . $name . '_' . $var->size . '.jpg'), 80);

          $result[$var->title] = array(
            'file' => $path . $name . '_' . $var->size . '.jpg',
            'size' => $var->size
          );
        };

        return json_encode($result);
    }

    function deleteImage($image)
    {
      $collection = json_decode($image['image']);

      foreach ($collection as $var) {
        File::delete(public_path($var->file));
      }
      return true;
    }

    function deleteEditorImage($src)
    {

      $path = explode(" ", $src['image']);
      $name = explode("_", $path[0])[0];
      $files = glob(public_path($name) . '*.jpg');

      foreach($files as $file) {
        File::delete($file);
      }
      return true;
    }


    function favicon($file)
    {
      $name = 'favicon.png';
      $path = '/img/icons/';

      File::makeDirectory(public_path($path), $mode = 0777, true, true);

      Image::make($file->getRealPath())->resize(300,300, function($constraint){
        $constraint->aspectRatio();
        $constraint->upsize();
      })->save(public_path($path . $name), 100);

      return $path . $name;
    }

    function deleteFavicon($image)
    {
      File::delete(public_path('/img/icons/favicon.png'));
      return true;
    }

}
