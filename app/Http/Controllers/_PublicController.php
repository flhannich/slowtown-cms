<?php

namespace App\Http\Controllers;

use App\Setting;
use App\Project;
use App\Page;
use App\Type;

use App\Http\Resources\PublicResources;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\File;

class PublicController extends Controller
{
  public function home()
  {
    $sitetags = Setting::select('title', 'description')->first();

    return view('public/home', compact('sitetags'));
  }

  public function page($slug)
  {

    $itemtags = Page::select('title', 'subtitle', 'description')->where('slug', $slug)->first();
    $sitetags = Setting::select('title', 'description')->first();

    return view('public/page', compact('slug', 'itemtags', 'sitetags'));
    //->with($headertags);
  }

  public function project($slug)
  {
    $itemtags = Project::select('title', 'description')->where('slug', $slug)->first();
    $sitetags = Setting::select('title', 'description')->first();
    return view('public/project', compact('slug', 'itemtags', 'sitetags'));

    // return view('public/project', compact('slug'));
  }

  public function login()
  {
    $sitetags = Setting::select('title', 'description')->first();

    return view('public/login', compact('sitetags'));
  }

  public function contact()
  {
    $sitetags = Setting::select('title', 'description')->first();

    return view('public/contact', compact('sitetags'));
  }

  public function getPage($slug)
  {
    $page = Page::select('content')->where('slug', $slug)->first();

    $json = File::get(public_path('data/types.json'));
    $types = json_decode($json, true);

    $items = json_decode($page['content'], true);


    $ids = array();

    foreach($items as $item)
    {
        $ids[] = $item['id'];
    }

    $projects = Project::whereIn('id', $ids)->get();

    $result = ['projects' => $projects, 'tags' => $tags, 'page' => $items, 'types' => $types];

    return $result;
  }

  // public function getPage($slug)
  // {
  //   $page = Page::select('content')->where('slug', $slug)->first();
  //
  //   return $page;
  // }

  public function getPages()
  {
    $main = Page::where('status', 2)
    ->where('menu', 0)
    ->get();

    $footer = Page::where('status', 2)
    ->where('menu', 1)
    ->get();

    $result = ['main' => $main, 'footer' => $footer];

    return $result;
  }

  // public function project($slug)
  // {
  //   return view('project', compact('slug'));
  // }
  //
  // public function category($category)
  // {
  //   return view('category', compact('category'));
  // }

public function getSettings() {
    $settings = Setting::first();

    return $settings;

    // return PublicResources::collection($settings);
}

public function getProject($slug) {

    $result = Project::where('slug', $slug)->get();

    return PublicResources::collection($result);
}



}
