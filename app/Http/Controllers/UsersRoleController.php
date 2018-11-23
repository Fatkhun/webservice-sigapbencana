<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\UsersRole;
use App\Model\Operation\BaseCrud;

class UsersRoleController extends Controller
{
    public function store(Request $request){
        $form   = $request->all();
        $roles  = UsersRole::$validation_role;

        $process    = new BaseCrud(new UsersRole());
        $res        = $process->create($form, $roles);
        return response()->json($res);
    }
}
