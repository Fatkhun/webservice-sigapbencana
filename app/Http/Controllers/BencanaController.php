<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Model\Bencana;
use App\Model\ImageBencana;
use App\Model\Operation\BaseCrud;

class BencanaController extends Controller
{

    public function dummy(){
        for ($i=1; $i <= 2000; $i++){
            
        }
    }


    // create
    public function create(Request $request){
        $form   = $request->all();
        $roles  = Bencana::$validation_role;

        
        unset($roles['luka_luka']);
        unset($roles['belum_ditemukan']);
        unset($roles['mengungsi']);
        unset($roles['meninggal']);
        unset($roles['status_id']);
        

        $process    = new BaseCrud(new Bencana());
        $resBencana = $process->createGetId($form, $roles); 
        
        return response()->json($form);
    }

    // monitor
    public function update(Request $request) {
        $form   = $request->all();
        $roles  = Bencana::$validation_role;
        $id     = $request->input('bencana_id');

        unset($roles['alamat']);
        unset($roles['users_id']);
        unset($roles['kategori_id']);      
        unset($form['image1']);
        unset($form['image2']);
        unset($form['image3']);
        unset($form['bencana_id']);
        $process    = new BaseCrud(new Bencana());
        $resUpdate        = $process->update($form, $roles, $id);

        $image1 = $request->file('image1');
        $image2 = $request->file('image2');
        $image3 = $request->file('image3');
        $image = [$image1, $image2, $image3];
        
        if($resUpdate){
            for($i=0; $i<count($image); $i++){
                $res = $this->addImage($id, $image[$i]);
            }
        }
        return response()->json($res);
    }

    public function addImage($bencanaId, $image){
        if($image == null){
            return false;
        }else{
            $imageName     = $bencanaId . "_" . time() . "_"
                . $image->getClientOriginalName();
            $imageUpload   = $image->move('asset/img/bencana/'
                . $bencanaId, $imageName);
            if ($imageUpload) {
                $bencanaImage   = new BaseCrud(new ImageBencana());
                $resImage = $bencanaImage->create([
                    'bencana_id'     => $bencanaId,
                    'path'          => '/asset/img/bencana/'. $bencanaId
                        . '/' . $imageName
                ], ImageBencana::$validation_role);
            }
            return true;
        }
    }

    // delete
    public function delete(Request $request, $id)
    {
        $process = new BaseCrud(new Bencana());
        $res = $process->delete($id);

        $image = new BaseCrud(new ImageBencana());
        $images = $image->findWhere(['bencana_id'=>$id]);

        for($i=0; $i<count($images); $i++){
            $process = new BaseCrud(new ImageBencana());
            $res = $process->delete($images[$i]->id);
        }
        return response()->json($res);


    }
}
