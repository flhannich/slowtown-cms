<?php

namespace App\Http\Controllers\App;

use App\Role;

use App\Http\Resources\RoleResources;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

class RolesController extends Controller
{
  public function __construct()
  {
      $this->middleware('auth');
  }

    public function show()
    {
      $roles = Role::all();

      return RoleResources::collection($roles);
    }

}
