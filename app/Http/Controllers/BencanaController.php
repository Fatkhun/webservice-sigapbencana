<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Model\Desa;
use App\Model\Bencana;
use App\Model\Lurah;
use App\Model\ImageBencana;
use App\Model\KategoriBencana;
use App\Model\Operation\BaseCrud;

class BencanaController extends Controller
{

    public function dummy(){
        $alamat     = ["Jl. BKR Pelajar No. 43","Jl. Koblen Tengah No. 22","Jl. Tanggulangin No. 12",
                        "Jl. Tambakrejo VI/2", "Jl. Mendut No. 7", "Kompleks Perumnas Balongsari Tandes ", "Jl. Raya Dukuh Kupang No. 83-A", "Jl. Teluk Sampit No. 2-A", "Jl. Sultan Iskandar Muda No. 16", "Jl. Gubeng Airlangga I/2"];
        $image      = ['asset/img/banjir.png', 'asset/img/kebakaran.jpg', 'asset/img/tsunami.jpg', 'asset/img/gunung.jpg', 'asset/img/gempa.jpg', 'asset/img/angin.jpg'];
        $index      = 1;
        for ($i=1; $i <= 2000; $i++){
            $randomLuka         = rand(0,100);
            $randomBelum        = rand(0,100);
            $randomMengungsi    = rand(0,100);
            $randomMeninggal    = rand(0,100);
            $randomUser         = rand(3,7858);
            $randomStatus       = rand(1,2);


            $randomAlamat   = rand(0,9);
            $randomKategori = rand(0,5);

            switch ($randomKategori) {
                case 0 :
                    $images = $image[0];
                    break;
                case 1 :
                    $images = $image[1];
                    break;
                case 2 :
                    $images = $image[2];
                    break;
                case 3 :
                    $images = $image[3];
                    break;
                case 4 :
                    $images = $image[4];
                    break;
                default :
                    $images = $image[5];
            }

            $randomBulan    = rand(3,12);
            $randomTanggal  = rand(1,30);

            if($randomBulan < 10){
                $randomBulan = '0' . $randomBulan;
            }
            if($randomTanggal < 10){
                $randomTanggal = '0' . $randomTanggal;
            }
            

            $createBencana = Bencana::create([
                'alamat'     => $alamat[$randomAlamat],
                'luka_luka'  => $randomLuka,
                'belum_ditemukan'   => $randomBelum,
                'mengungsi'  => $randomMengungsi,
                'meninggal'   => $randomMeninggal,
                'users_id'  => $randomUser,
                'kategori_id'   => $randomKategori + 1,
                'status_id'  => $randomStatus + 1,
                'created_at'   => '2018-'. $randomBulan.'-'.$randomTanggal . ' 15:40:45',
                'updated_at'   => '2018-'. $randomBulan.'-'.$randomTanggal . ' 15:40:45'
            ]);
            
            if($createBencana){
                $imageBencana = ImageBencana::create([
                    'path'          => $images,
                    'bencana_id'    => $index
                ]);
            }
            $index++;

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

    public function getDetail(Request $request, $id){
        $bencana = Bencana::with([
            'image_bencana', 
            'user'=> function($query){
                return $query->with('lurah')->get();
            }
        ])->where('id', $id)->get();
        
        return response()->json($bencana);
    }

    public function getAll(){
        $bencana = Bencana::with([
            'image_bencana', 'status_bencana', 'user' => function($query){
                return $query->with('lurah')->get();
            }
        ])
        ->whereIn('status_id', ['2', '3'])->paginate(10);
        
        return response()->json($bencana);
    }

    public function getLaporanTerbaru(){
        $bencana = Bencana::where('status_id', '1')->paginate(5);

        return response()->json($bencana);
    }

    public function getStatistikBulan(){
        $bulan  = date('Y-m');
        $kategori = KategoriBencana::get();
        
        $data = [];

        for($i=0; $i < count($kategori); $i++){
            $bencana = Bencana::where('created_at', 'like', $bulan. '%')
            ->where('kategori_id',$kategori[$i]->id)
            ->count();

            $data = $this->arrayPush($data, $kategori[$i]->nama ,$bencana);
            
        }

        $res = [
            'success' => true,
            'data'    => $data
        ];

        return response()->json($res);
    }

    public function getStatistikTahun(){
        $year = date('Y').'-';
        $data = [];
        $bulan = ['01','02','03','04','05','06','07','08','09','10','11','12'];
        $month = ['januari', 'pebruari', 'maret', 'april', 'mei', 'juni', 'juli', 'agustus', 'september', 'oktober', 'nopember', 'desember'];
        $kategori = KategoriBencana::get();

        for($i=0; $i< count($bulan); $i++){
            $dataBulan = [];
            for($j=0; $j< count($kategori); $j++){
                $bencana = Bencana::where('created_at', 'like', $year.$bulan[$i].'%')
                ->where('kategori_id',$kategori[$j]->id)->count();
                $dataBulan = $this->arrayPush($dataBulan, $kategori[$j]->nama, $bencana);
            }
            $data = $this->arrayPush($data, $month[$i], $dataBulan);
        }

        return response()->json($data);
    }

    public function getDataBencanaTahun(){
        $year = date('Y');

        $laporan = Bencana::where('created_at', 'like', $year.'%')
        ->count();
        $bencana = Bencana::where('created_at', 'like', $year.'%')
        ->whereIn('status_id', ['2','3'])
        ->count();
        $evakuasi = Bencana::where('created_at', 'like', $year.'%')
        ->where('status_id', '2')
        ->count();
        $rehab = Bencana::where('created_at', 'like', $year.'%')
        ->where('status_id', '3')
        ->count();

        $res = [
            'success' => true,
            'message' => "Data ditemukan.",
            'data'    => [
                'laporan'       => $laporan,
                'bencana'       => $bencana,
                'evakuasi'      => $evakuasi,
                'rehabilitasi'  => $rehab
            ]
        ];

        return response()->json($res);
    }


    public function jumlahBencana(Request $request, $kategori, $kabupaten, $tahun){
        
        $data = [];
        $desa = Desa::where('kabupaten_id', $kabupaten)->get();
        // $lurah = Lurah::whereIn('desa_id', $desa->id);

        for ($i=0; $i < count($desa); $i++){
            $bencana = Bencana::where('created_at', 'like', $tahun.'%')
            ->where('kategori_id', $kategori)
            ->where('users_id', $desa[$i]->id)
            ->count();

            $data = $this->arrayPush($data, $desa[$i]->nama, $bencana);
        }

        $res = [
            'success'   => true,
            'data'      => $data
        ];

        return response()->json($res);

    }

    public function rekap(Request $request, $kabupaten, $tahun){
        $desa = Desa::where('kabupaten_id', $kabupaten)->get();
        $kategori = KategoriBencana::get();

        $dataDesa = [];
        for($i=0; $i< count($desa); $i++){
            array_push($dataDesa, $desa[$i]->id);
        }
        $dataKategori = [];
        for ($i=0; $i < count($kategori); $i++){
            $dataCount = [];
            $lukaCount = 0;
            $mengungsiCount = 0;
            $meninggalCount = 0;
            $bencana = Bencana::where('created_at', 'like', $tahun.'%')
                            ->where('kategori_id', $kategori[$i]->id)
                            ->whereIn('users_id', $dataDesa)
                            ->get();

            for($k=0; $k < count($bencana); $k++){
                $lukaCount += $bencana[$k]->luka_luka;
                $mengungsiCount += $bencana[$k]->mengungsi;
                $meninggalCount += $bencana[$k]->meninggal; 
            }

            $dataCount = $this->arrayPush($dataCount, 'kejadian', count($bencana));
            $dataCount = $this->arrayPush($dataCount, 'luka', $lukaCount);
            $dataCount = $this->arrayPush($dataCount, 'mengungsi', $mengungsiCount);
            $dataCount = $this->arrayPush($dataCount, 'meninggal', $meninggalCount);
                
            $dataKategori = $this->arrayPush($dataKategori, $kategori[$i]->nama, $dataCount);
        }

        $res = [
            'success'   => true,
            'data'      => $dataKategori
        ];

        return response()->json($res);
    }

    public function arrayPush($array, $key, $value){
        $array[$key] = $value;
        return $array;
    }


}
