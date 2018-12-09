<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Model\KategoriBencana;
use App\Model\Operation\BaseCrud;

class KategoriBencanaController extends Controller
{
    // create
    public function create(Request $request){
        $form   = $request->all();
        $roles  = KategoriBencana::$validation_role;

        $process  = new BaseCrud(new KategoriBencana());
        $res            = $process->createGetId($form, $roles);
        return response()->json($res);
    }

    // update
    public function update(Request $request, $id) {
        $form   = $request->all();
        $roles  = KategoriBencana::$validation_role;
        $process    = new BaseCrud(new KategoriBencana());
        $res        = $process->update($form, $roles, $id);
        return response()->json($res);
    }

    // delete
    public function delete(Request $request, $id)
    {
        $process = new BaseCrud(new KategoriBencana());
        $res = $process->delete($id);
        return response()->json($res);
    }

    public function getAll(Request $request){
        $process  = new BaseCrud(new KategoriBencana());
        $res      = $process->findAll();
        return response()->json($res);
    }
}
