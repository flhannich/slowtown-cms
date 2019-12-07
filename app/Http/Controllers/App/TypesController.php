<?php

namespace App\Http\Controllers\App;


use App\Type;
use App\Project;
use App\Http\Resources\TypeResources;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\File;

use App\Http\Controllers\Controller;

class TypesController extends Controller
{
  public function __construct()
  {
      $this->middleware('auth');
  }

    public function show()
    {
      $json = File::get(public_path('data/types.json'));
      $types = json_decode($json, true);

      return $types;

      // return TypeResources::collection($types);
    }

    public function update(Project $project, Type $type) {

        $project->updateType($type);

        return back();
    }

}
