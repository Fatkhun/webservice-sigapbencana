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
        $berita     = Berita::with(
            ['bencana' => function($query){
                return $query->with(
                    ['image_bencana'])->get();
            }])->where('id', $id)->get();
        return response()->json($berita);
    }

    public function getAll(){
        $berita     = Berita::with(
            ['bencana' => function($query){
                return $query->with(
                    ['user' => function($query){
                        return $query->with('admin_sar')->get();
                }, 'image_bencana'=> function($query){
                        return $query->with('image_bencana')->get();
                }])->get();
            }])->get();

        return response()->json($berita);
    }
}
