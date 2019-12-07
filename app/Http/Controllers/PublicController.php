<?php

namespace App\Http\Controllers;

use App\Setting;
use App\Project;
use App\Page;
use App\Tag;
use App\Type;

use App\Http\Resources\PublicResources;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\File;

class PublicController extends Controller
{
  public function home()
  {
    $sitetags = Page::select('title', 'subtitle', 'description')->first();

    return view('public/home', compact('sitetags'));
  }

  public function page($slug)
  {

    $itemtags = Page::select('title', 'subtitle', 'description')->where('slug', $slug)->first();
    $sitetags = Setting::select('title', 'subtitle', 'description')->first();

    return view('public/page', compact('slug', 'itemtags', 'sitetags'));
    //->with($headertags);
  }

  public function project($slug)
  {
    $itemtags = Project::select('title', 'description')->where('slug', $slug)->first();
    $sitetags = Setting::select('title', 'subtitle', 'description')->first();
    return view('public/project', compact('slug', 'itemtags', 'sitetags'));

    // return view('public/project', compact('slug'));
  }

  public function login()
  {
    $sitetags = Setting::select('title', 'subtitle', 'description')->first();

    return view('public/login', compact('sitetags'));
  }

  public function contact()
  {
    $sitetags = Setting::select('title', 'subtitle', 'description')->first();

    return view('public/contact', compact('sitetags'));
  }

  public function getPage($slug)
  {
    $page = Page::select('content')->where('slug', $slug)->first();

    $json = File::get(public_path('data/types.json'));
    $types = json_decode($json, true);

    $pageItems = json_decode($page['content'], true);


    $projectIds = array();
    $tagIds = array();

    foreach($pageItems as $item)
    {
        if($item['title'] == 'project') {
          $projectIds[] = $item['id'];
        }
        if($item['title'] == 'tag') {
          $tagIds[] = $item['id'];
        }
    }

    $tags = null;
    $projects = null;

    if(!empty($projectIds))
    {
      $projects = Project::whereIn('id', $projectIds)->where('status', 2)->with('users')->get();
    }
    if(!empty($tagIds))
    {
      $tags = Tag::whereIn('id', $tagIds)->with(['project' => function ($query) {
          $query->where('status', 2)->orderBy('weight', 'desc');
      }])->with('project.users')->get();
    }

    $result = ['projects' => $projects, 'tags' => $tags, 'page' => $pageItems, 'types' => $types];

    return $result;
  }

  // public function getPage($slug)
  // {
  //   $page = Page::select('content')->where('slug', $slug)->first();
  //
  //   return $page;
  // }

    public function getMenu()
  {
    return Page::where('status', 2)->select('title', 'slug', 'menu', 'cta')->get();
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
