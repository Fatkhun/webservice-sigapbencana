<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Model\KondisiBencana;
use App\Model\Operation\BaseCrud;

class KondisiBencanaController extends Controller
{
    // create
    public function create(Request $request){
        $form   = $request->all();
        $roles  = KondisiBencana::$validation_role;

        $process  = new BaseCrud(new KondisiBencana());
        $res            = $process->createGetId($form, $roles);
        return response()->json($res);
    }

    // update
    public function update(Request $request, $id) {
        $form   = $request->all();
        $roles  = KondisiBencana::$validation_role;
        $process    = new BaseCrud(new KondisiBencana());
        $res        = $process->update($form, $roles, $id);
        return response()->json($res);
    }

    // delete
    public function delete(Request $request, $id)
    {
        $process = new BaseCrud(new KondisiBencana());
        $res = $process->delete($id);
        return response()->json($res);
    }
}
