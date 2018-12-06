<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\Model\UsersRole;
use App\Model\Lurah;
use App\Model\AdminSar;
use App\Model\Kabupaten;
use App\Model\AdminBPBD;
use App\Model\Operation\BaseCrud;
use Auth;

class UserController extends Controller
{
    /**
     * Register new user
     *
     * @param $request Request
     */
    public function register(Request $request){

        // Validate all input fields
        $this->validate($request, [
            'email'     => 'required|string',
            'password'  => 'required|string',
            'role_id'   => 'required',
        ]);
        $hasher     = app()->make('hash');
        $nama       = $request->input('nama');
        $email      = $request->input('email');
        $roleId     = $request->input('role_id');
        $user       = User::where('email', $email)->first();
        
        if ($user) {
            $res['success']     = false;
            $res['message']     = 'Email sudah digunakan!';
            return response()->json($res);
        }else{
            $password = $hasher->make($request->input('password'));
            $register = User::create([
                'email'     => $email,
                'password'  => $password,
                'role_id'   => $roleId
            ]);
            
            

            if ($register) {
                if($roleId == '1'){
                    $desaId = $request->input('desa_id');
                    $periode = $request->input('periode');
                    $alamat = $request->input('alamat');
                    $image = '/asset/img/lurah.png';
                    $lurah = Lurah::create([
                        'nama'      => $nama,
                        'periode'   => $periode,
                        'image'     => $image,
                        'alamat'    => $alamat,
                        'desa_id'   => $desaId,
                        'user_id'   => $register->id
                    ]);
                }else if($roleId == '2'){
                    $adminSar = AdminSar::create([
                        'nama'      => $nama,
                        'user_id'   => $register->id
                    ]);
                }else if($roleId == '3'){
                    $adminBPBD = AdminBPBD::create([
                        'nama'  => $nama,
                        'user_id'   => $register->id
                    ]);
                }
                $res['success'] = true;
                $res['message'] = 'Berhasil daftar akun';
                return response()->json($res);
            }else{
                $res['success'] = false;
                $res['message'] = 'Gagal daftar akun!';
                return response()->json($res);
            }
        }
    }

    /**
     * Index login controller
     *
     * When user success login will retrive callback as api_token
     */
    public function login(Request $request){
        // Validate all input fields
        $this->validate($request, [
            'email' => 'required|string',
            'password' => 'required|string'
        ]);
        $hasher = app()->make('hash');
        $email = $request->input('email');
        $password = $request->input('password');

        $user = User::where('email', $email)->first();
        
        if (!$user) {
            $res['success'] = false;
            $res['message'] = 'Password atau email salah!';
            return response()->json($res);
        }else{
            if ($hasher->check($password, $user->password) ) {
                $api_token = sha1(time());
                $create_token = User::where('id', $user->id)->update(['api_token' => $api_token]);
                if ($create_token) {
                    $user = $this->getDetail($user);

                    $res['success'] = true;
                    $res['message'] = 'Berhasil login';
                    $res['data']    = $user;
                    
                    return response()->json($res);
                }else {
                    $res['success'] = false;
                    $res['message'] = 'Gagal login';
                    return response()->json($res);
                }
            }else{
                $res['success'] = false;
                $res['message'] = 'Password atau email salah!';
                return response()->json($res);
            }
        }
    }


    
    public function showUser(Request $request, $id){
        $user = User::where('id', $id)->first();
        
        if ($user) {
            $user = $this->getDetail($user);

            $res['success'] = true;
            $res['message'] = 'Data ditemukan';
            $res['data'] = $user;
            return response()->json($res);
        }else{
            $res['success'] = false;
            $res['message'] = 'Data tidak ditemukan!';
            return response()->json($res);
        }
    }


    public function getUserKabupaten(Request $request, $id){
        $kabupaten = Kabupaten::with(
                                ['desa'=> function($query){
                                            return $query->with('lurah')->get();
                                        }
                                ]
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

    public function updateUserProfile(Request $request, $id){
      $updateUser = User::where('id', $id)->first();
      $updateUser->nama = $request->input('nama');
      $updateUser->email = $request->input('email');
      $updateUser->save();
      if ($updateUser) {
        $res['success'] = true;
        $res['message'] = 'Berhasil update data';
        $res['data'] = $updateUser;
        return response()->json($res);
      }else{
        $res['success'] = false;
        $res['message'] = 'Gagal update data!';
        return response()->json($res);
      }
    }

    public function updatePassword(Request $request){
      $this->validate($request, [
          'old_password'          => 'required',
          'password'              => 'required',
      ]);

      $data = $request->all();
      $user = User::find(Auth::user()->id);
      if(!Hash::check($data['old_password'], $user->password)){
          $res['success'] = false;
          $res['message'] = 'Gagal update password';
          return response()->json($res);
      }else{
         // write code to update password
         $user->fill([
          'password' => Hash::make($request->password)
          ])->save();
         $res['success'] = true;
         $res['message'] = 'Berhasil update password';
         return response()->json($res);
      }
    }

    // delete user by id
    public function destroyUser(Request $request, $id){
      $destroyUser = User::where('id',$id)->first();
      $destroyUser->delete();
      if ($destroyUser) {
        $res['success'] = true;
        $res['message'] = 'Berhasil menghapus data';
        return response()->json($res);
      }else{
        $res['success'] = false;
        $res['message'] = 'Gagal menghapus data!';
        return response()->json($res);
      }
    }


    public function getDetail($user){
        if($user->role_id == '1'){
            $user = User::with(['lurah'])->where('id', $user->id)->get();
        }else if($user->role_id == '2'){
            $user = User::with(['admin_sar'])->where('id', $user->id)->get();
        }else{
            $user = User::with(['admin_bpbd'])->where('id', $user->id)->get();
        }

        return $user;
    }
}
