<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Kabupaten;
use App\Model\Desa;
use App\Model\Operation\BaseCrud;

class KabupatenController extends Controller
{
    public function getAll(){
        $kabupaten  = new BaseCrud(new Kabupaten());
        $res        = $kabupaten->findAll();

        return response()->json($res);
    }

    public function getDesa(Request $request, $id){
        $kabupaten = Kabupaten::with(
            ['desa']
        )->where('id', $id)->get();
        
        if ($kabupaten) {
            $res['success'] = true;
            $res['message'] = 'Data ditemukan';
            $res['data'] = $kabupaten;
            
            return response()->json($res);
        }else{
            $res['success'] = false;
            $res['message'] = 'Data tidak ditemukan!';
            
            return response()->json($res);
        }
    }
}
