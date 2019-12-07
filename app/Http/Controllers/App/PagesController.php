<?php

namespace App\Http\Controllers\App;

use App\Page;
use App\Project;
use App\Tag;
use App\Settings;


use App\Http\Resources\PagesResources;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\File;


class PagesController extends Controller
{

  public function __construct()
  {
      $this->middleware('auth');
  }


  // public function projects(Page $page)
  // {
  //   $page_db = Page::select('content')->where('title', $page)->first();
  //
  //   $projects = json_decode($page_db['content'], true);
  //
  //   $arr = array();
  //
  //   foreach($projects as $i => $item)
  //   {
  //       $arr[] = $item['id'];
  //   }
  //
  //   $result = Project::whereIn('id', $arr)->with('type')->get();
  //
  //   return SettingsResources::collection($result);
  // }

  public function show()
  {
    $drafts = Page::where('status', 0)
      ->orderBy('updated_at', 'desc')
      ->get();

    $published = Page::where('status', 2)
      ->orderBy('updated_at', 'desc')
      ->get();

    $arr = array('drafts' => $drafts, 'published' => $published);

    return json_encode($arr);
  }

  public function edit($slug)
  {
      $page = Page::where('slug', $slug)->first();

      $json = File::get(public_path('data/types.json'));
      $types = json_decode($json, true);

      $result = ['page' => $page, 'types'=> $types];

      return $result;
  }

  public function getProjects($slug)
  {
      $pageItems = json_decode(request()->page, true);

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
      $groups = null;
      $projects = null;

      if(!empty($projectIds))
      {
        $projects = Project::whereIn('id', $projectIds)->where('status', 2)->with('users')->get();
      }
      if(!empty($tagIds))
      {
        $tags = Tag::whereIn('id', $tagIds)->get();


        // $tagProjects = Project::has('tags')->get();

        $groups = Project::whereHas('tags', function ($q) use ($tagIds) {
            $q->whereIn('id', $tagIds);
        })
          ->where('status', 2)
          ->with('tags')
          ->orderBy('weight', 'DESC')
          ->get();



        // $tags = Tag::whereIn('id', $tagIds)->with(['project' => function ($query) {
        //     $query->where('status', 2)->orderBy('weight', 'DESC');
        // }])
        // ->with('project.users')
        // ->get();
      }
      $result = ['projects' => $projects, 'groups' => $groups];
      return $result;
  }


  public function create()
  {
    if(Page::checkUpdateAuth())
    {
      $slug = str_random(10);

      $attributes = ([
        'title' => 'New Draft',
        'subtitle' => '',
        'description' => '',
        'content' => '[]',
        'slug' => $slug,
        'status' => 0, // Draft
        'menu' => 0, // Main Menu
        'cta' => 0
      ]);

      Page::create($attributes);

      return response()->json(['slug'=> $slug]);
    }
    else {
      return response()->json(['message'=> 'No permission']);
    }
  }

  public function update(Page $page)
  {
    if(Page::checkUpdateAuth())
    {
      $newSlug = str_slug(request()->title, '-');

      $attributes = request()->validate([
        'title' => ['required'],
        'content' => ['required'],
        'menu' => ['required'],
        'status' => ['required']
      ]);

      $attributes += ([
        'subtitle' => request()->subtitle,
        'description' => request()->description,
        'cta' => request()->cta
      ]);

      $attributes += ([
        'slug' => $newSlug,
      ]);

      $page->update($attributes);

      if(request()->status == 2)
      {
        return response()->json(['message'=> 'Updated']);
      }
    }
    else
    {
      return response()->json(['message'=> 'No permission']);
    }
  }

  public function delete(Page $page)
  {
    if(Page::checkUpdateAuth())
    {
      $page->delete();
      return response()->json(['message'=> 'Updated']);
    }
    else {
      return response()->json(['message'=> 'No permission']);
    }
  }

    public function pages()
    {
      return view('app/pages');
    }

    public function page($slug)
    {
      return view('app/page', compact('slug'));
    }

    public function project($slug)
    {
      return view('app/project', compact('slug'));
    }

    public function settings()
    {
      return view('app/settings');
    }

    public function profile()
    {
      return view('app/profile');
    }

    public function dashboard()
    {
      return view('app/dashboard');
    }





    // public function project($slug, Twitter $twitter)
    // {
    //   $project = Project::where('slug', $slug)->with('users')->first();
    //
    //   return view('projects.show', compact('project'));
    // }
}
