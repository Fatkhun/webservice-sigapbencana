<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Pengumuman;
use App\Model\Operation\BaseCrud;

class PengumumanController extends Controller
{
    // ini tidak termasuk target progress
     // create
     public function create(Request $request){
        $form   = $request->all();
        $roles  = Pengumuman::$validation_role;

        $process  = new BaseCrud(new Pengumuman());
        $res            = $process->createGetId($form, $roles);
        return response()->json($res);
    }

    // update
    public function update(Request $request, $id) {
        $form   = $request->all();
        $roles  = Pengumuman::$validation_role;
        $process    = new BaseCrud(new Pengumuman());
        $res        = $process->update($form, $roles, $id);
        return response()->json($res);
    }

    // delete
    public function delete(Request $request, $id)
    {
        $process = new BaseCrud(new Pengumuman());
        $res = $process->delete($id);
        return response()->json($res);
    }
}
