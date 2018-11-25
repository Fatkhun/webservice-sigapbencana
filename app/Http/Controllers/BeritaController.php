<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Bencana;
use App\Model\ImageBencana;
use App\Model\Operation\BaseCrud;
use App\Model\Berita;

class BeritaController extends Controller
{
    // create
    public function create(Request $request){
        $form   = $request->all();
        $roles  = Berita::$validation_role;

        $process  = new BaseCrud(new Berita());
        $res            = $process->createGetId($form, $roles);
        return response()->json($res);
    }

    // update
    public function update(Request $request, $id) {
        $form   = $request->all();
        $roles  = Berita::$validation_role;
        $process    = new BaseCrud(new Berita());
        $res        = $process->update($form, $roles, $id);
        return response()->json($res);
    }

    // delete
    public function delete(Request $request, $id)
    {
        $process = new BaseCrud(new Berita());
        $res = $process->delete($id);
        return response()->json($res);
    }

    public function detail(Request $request, $id){
        $berita     = new BaseCrud(new Berita());
        $resBerita  = $berita->findById($id);

        $bencana    = new BaseCrud(new Bencana());
        $resBencana = $bencana->findById($resBerita['bencana_id']);

        $image      = new BaseCrud(new ImageBencana());
        $resImage   = $image->findWhere(['bencana_id' => $resBerita['bencana_id']]);
        $res = [
            'berita'    => $resBerita,
            'bencana'   => $resBencana,
            'image'     => $resImage
        ];

        return response()->json($res);
    }
}
