<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Lurah;
use App\User;

class LurahController extends Controller
{   
    // initisalisasi dummy lurah
    public function dummy(){
        $nama       = ["Ridwan Mubarun","Budi Hermanto","Hindun Robba Humaidiyah ","Dodot Wahluyo","Muslich Hariadi","Agus Setyoko","Achmad Widyantoro","Achmad Zaini","Dewanto Kusumo Legowo","Ahmad Daya Prasetyono","Harun Ismail","Henni Indriaty","Denny Christupel Tupamahu","Eko Budi Susilo","Tomi Ardiyanto"];
        $alamat     = ["Jl. BKR Pelajar No. 43","Jl. Koblen Tengah No. 22","Jl. Tanggulangin No. 12",
                        "Jl. Tambakrejo VI/2", "Jl. Mendut No. 7", "Kompleks Perumnas Balongsari Tandes ", "Jl. Raya Dukuh Kupang No. 83-A", "Jl. Teluk Sampit No. 2-A", "Jl. Sultan Iskandar Muda No. 16", "Jl. Gubeng Airlangga I/2"];
        
        $hasher     = app()->make('hash');
        $password   = $hasher->make('lurah');
        $roleId     = '1';
        $periode    = '2018 - 2022';
        $image      = 'asset/img/lurah.png';
        $desaId     = 1;
        $userId     = 3;
        $desaCount  = 7856;

        for ($i=1; $i<= $desaCount; $i++){
            $randomAlamat = rand(0,9);
            $randomNama   = rand(0,14); 
            
            $createUser = User::create([
                'email'     => strtolower(str_replace(' ', '', $nama[$randomNama])) . $i . '@gmail.com',
                'password'  => $password,
                'role_id'   => $roleId
            ]);

            if($createUser){
                $createLurah = Lurah::create([
                    'nama'      => $nama[$randomNama],
                    'periode'   => $periode,
                    'image'     => $image,
                    'alamat'    => $alamat[$randomAlamat],
                    'desa_id'   => $desaId,
                    'user_id'   => $userId
                ]);

                if($createLurah){
                    $desaId++;
                    $userId++;
                }
            }
        }

        $res = "Selesai";
        
        return response()->json($res);
    }
}
