<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
    public function store(Request $request) {
        $form   = $request->all();
        $roles  = ProdukInovasiModel::$validation_roles;
        $kerjasama  = $form['kerjasama_id'];
        $validate_image = Validator::make($form, [
            'image' => 'required|images|mimes:jpeg,png,jpg,gif,svg|max:10000',
        ]);
        if (!$validate_image) {
            $res = GlobalVar::$VALIDATE_IMAGE_FAILED;
            return redirect()
                ->route('admin.produk.add')
                ->with($res);
        }
        $image      = $request->file('image');
        $hki        = [
            'hki_no'        => $form['hki_no'],
            'hki_keterangan'=> $form['hki_keterangan'],
            'hki_file'      => $request->file('hki_file')
        ];
        unset($roles['ketua_id']);
        unset($form['kerjasama_id']);
        unset($form['hki_no']);
        unset($form['hki_keterangan']);
        unset($form['hki_file']);
        unset($form['image']);
        $form['ketua_id'] = Auth::user()->id;
        $form['is_monitored'] = 0;
        $produk_inovasi = new BaseCrud(new ProdukInovasiModel());
        $res_produk_ino = $produk_inovasi->createGetId($form, $roles);
        $res    = $this->addKerjasama($res_produk_ino['data']['id'], $kerjasama);
        if (!$res) return response()->json(GlobalVar::$SAVE_FAILED);
        $res    = $this->addImage($res_produk_ino['data']['id'], $image);
        if (!$res) return response()->json(GlobalVar::$FAILED_SAVE_FILE);
        $res    = $this->addHki($res_produk_ino['data']['id'], $hki);
        if (!$res) return response()->json(GlobalVar::$SAVE_FAILED);
        return redirect()
                ->route('admin.produk', ['jenis'=>1])
                ->with($res);
    }
    public function getListProduk(Request $request, $jenis_id) {
        $res = ProdukInovasiModel::with(['ketua', 'produk_image'])
            ->whereHas('skema', function($query) use ($jenis_id) {
            $query->where('jenis_id', $jenis_id);
        })->get();
        // return response()->json($res);
        return redirect()
                ->route('admin.produk', ['jenis'=>$jenis_id])
                ->with($res);
    }
    public function getDetailProduk(Request $request, $id) {
        $getJenis = new BaseCrud(new JenisModel());
        $jenis = $getJenis->findAll();
        $getSkema   = new BaseCrud(new SkemaPendanaanModel());
        $skema      = $getSkema->findAll();
        $getBidang = new BaseCrud(new BidangFokusModel());
        $bidang = $getBidang->findAll();
        $getKerjasama = new BaseCrud(new KerjasamaBisnisModel());
        $kerjasama    = $getKerjasama->findAll();
        $produk    = ProdukInovasiModel::with(['ketua', 'produk_image',
            'produk_kerjasama' => function($query) {
                return $query->with('kerjasama')->get();
            }, 'produk_hki', 'skema', 'bidang'])->where('id', $id)->get();
            // return response()->json($produk);
        return view('admin.pages.produk.detail', compact('produk','jenis','skema', 'bidang', 'kerjasama'));
    }
    public function addImageProduk(Request $request, $produk_id) {
        $image  = $request->file('image');
        $res    = $this->addImage($produk_id, $image);
        // if ($res) return response()->json(GlobalVar::$SAVE_SUCCESS);
        // else return response()->json(GlobalVar::$FAILED_SAVE_FILE);
        return redirect()
                ->route('produk.detail', ['id'=>$produk_id])
                ->with($res);
    }
    public function addImage($produk_id, $image) {
        if ($image != null) {
            $image_name     = $produk_id . "_" . time() . "_"
                . $image->getClientOriginalName();
            $image_upload   = $image->move(public_path('assets/img/produk/'
                . $produk_id), $image_name);
            if ($image_upload) {
                $produk_image   = new BaseCrud(new ProdukImageModel());
                $res_produk_img = $produk_image->create([
                    'produk_id'     => $produk_id,
                    'image'         => $image_name,
                    'path'          => 'assets/img/produk/'. $produk_id
                        . '/' . $image_name
                ], ProdukImageModel::$validation_roles);
            }
            return true;
        } else {
            return false;
        }
    }
    public function addHkiProduk(Request $request, $produk_id) {
        $form   = $request->all();
        $hki        = [
            'hki_no'        => $form['hki_no'],
            'hki_keterangan'=> $form['hki_keterangan'],
            'hki_file'      => $request->file('hki_file')
        ];
        $res    = $this->addHki($produk_id, $hki);
        // if ($res) return response()->json(GlobalVar::$SAVE_SUCCESS);
        // else return response()->json(GlobalVar::$SAVE_FAILED);
        return redirect()
                ->route('produk.detail', ['id'=>$produk_id])
                ->with($res);
    }
    public function addHki($produk_id, $hki) {
        if ($hki != null || $hki != []) {
            $hki_file     = $produk_id . "_". time() . "_"
                . $hki['hki_file']->getClientOriginalName();
            $hki_upload   = $hki['hki_file']->move(public_path('assets/file/produk/'
                . $produk_id), $hki_file);
            if ($hki_upload) {
                $produk_hki   = new BaseCrud(new ProdukHkiModel());
                $res_produk_hki = $produk_hki->create([
                    'produk_id'     => $produk_id,
                    'hki_no'        => $hki['hki_no'],
                    'hki_keterangan'=> $hki['hki_keterangan'],
                    'file'          => 'assets/file/produk/'.
                        $produk_id . '/' . $hki_file
                ], ProdukHkiModel::$validation_roles);
            }
            return true;
        } else {
            return false;
        }
    }
    public function addKerjasamaProduk(Request $request, $produk_id) {
        $form   = $request->all();
        $kerjasama  = $form['kerjasama_id'];
        $res    = $this->addKerjasama($produk_id, $kerjasama);
        if ($res) return response()->json(GlobalVar::$SAVE_SUCCESS);
        else return response()->json(GlobalVar::$SAVE_FAILED);
    }
    public function addKerjasama($produk_id, $kerjasama) {
        if ($kerjasama == [""]) {
            return GlobalVar::$SAVE_FAILED;
        } else if ($kerjasama != null || $kerjasama != []) {
            foreach ($kerjasama as $ks) {
                $produk_kerjasama   = new BaseCrud(new ProdukKerjasamaModel());
                $res_produk_ks      = $produk_kerjasama->create([
                    'produk_id'     => $produk_id,
                    'kerjasama_id'  => $ks
                ]);
            }
            return true;
        } else {
            return false;
        }
    }
    public function update(Request $request, $id) {
        $form   = $request->all();
        $roles  = ProdukInovasiModel::$validation_roles;
        $process    = new BaseCrud(new ProdukInovasiModel());
        $res        = $process->update($form, $roles, $id);
        return response()->json($res);
    }
    public function delete(Request $request, $id)
    {
        $process = new BaseCrud(new ProdukInovasiModel());
        $res = $process->delete($id);
        return redirect()
                ->route('admin.produk', ['jenis'=>1])
                ->with($res);
    }
    public function export(Request $request, $jenis_id) {
        $data = ProdukInovasiModel::with(['ketua', 'produk_image'])
            ->whereHas('skema', function($query) use ($jenis_id) {
                $query->where('jenis_id', $jenis_id);
            })
            ->get();
        return Excel::create('produk_' . date("d_m_Y_h:i:s"),
            function ($excel) use ($data) {
                $excel->sheet('produk_', function ($sheet) use ($data) {
                    $sheet->fromArray($data);
                });
            })->download("xls");
    }
    public function produkFilter(Request $request, $jenis_id)
    {
        $getJenis = new BaseCrud(new JenisModel());
        $jenis = $getJenis->findAll();
        $getJenisMenu = new BaseCrud(new JenisModel());
        $jenismenu = $getJenis->findWhere(['id'=>$jenis_id]);
        $getSkema   = new BaseCrud(new SkemaPendanaanModel());
        $skema      = $getSkema->findWhere(['jenis_id'=>$jenis_id]);
        $getBidang = new BaseCrud(new BidangFokusModel());
        $bidang = $getBidang->findAll();
        $data = ProdukInovasiModel::with(['ketua', 'produk_image'])
            ->whereHas('skema', function($query) use ($jenis_id) {
                $query->where('jenis_id', $jenis_id)->where('is_active', 1);
            })
            ->get();
        if (Auth::user()->id != 1) {
            $data = ProdukInovasiModel::with(['ketua', 'produk_image'])
                ->whereHas('skema', function($query) use ($jenis_id) {
                    $query->where('jenis_id', $jenis_id)->where('is_active', 1);
                })
                ->where('ketua_id', Auth::user()->id)
                ->where('skema_id', $request->input('skema_id'))
                ->where('bidang_id', $request->input('bidang_id'))
                ->get();
        }
//        return $data;
        return view('admin.pages.produk.index', compact('data','jenis','skema', 'bidang', 'jenismenu'));
    }

}
