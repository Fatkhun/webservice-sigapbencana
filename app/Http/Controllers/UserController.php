<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\User;
use Auth;

class UserController extends Controller
{
    /**
     * Register new user
     *
     * @param $request Request
     */
    public function register(Request $request)
    {

        // Validate all input fields
        $this->validate($request, [
            'nama'  => 'required|string',
            'email' => 'required|string',
            'password' => 'required|string'
        ]);
        $hasher = app()->make('hash');
        $username = $request->input('nama');
        $email = $request->input('email');
        $user = User::where('email', $email)->first();
        if ($user) {
            $res['success'] = false;
            $res['message'] = 'Email sudah digunakan!';
            $res['result'] = null;
            return response()->json($res);
        }else{
            $password = $hasher->make($request->input('password'));
            $register = User::create([
                'nama'=> $username,
                'email'=> $email,
                'password'=> $password,
            ]);
            if ($register) {
                $res['success'] = true;
                $res['message'] = 'Berhasil daftar akun';
                $res['result'] = $register;
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
    public function login(Request $request)
    {
        // Validate all input fields
        $this->validate($request, [
            'email' => 'required|string',
            'password' => 'required|string'
        ]);
        $hasher = app()->make('hash');
        $email = $request->input('email');
        $password = $request->input('password');
        $login = User::where('email', $email)->first();
        if (!$login) {
            $res['success'] = false;
            $res['message'] = 'Password atau email salah!';
            return response()->json($res);
        }else{
            if ($hasher->check($password, $login->password) ) {
                $api_token = sha1(time());
                $create_token = User::where('id', $login->id)->update(['api_token' => $api_token]);
                if ($create_token) {
                    $userLogin = User::where('id', $login->id)->first();
                    $res['success'] = true;
                    $res['message'] = 'Berhasil login';
                    $res['user'] = $userLogin;
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


    /**
     * Get user by id
     *
     * URL /user/{id}
     */
    public function showUser(Request $request, $id)
    {
        $user = User::where('id', $id)->get();
        if ($user) {
            $res['success'] = true;
            $res['message'] = 'Data ditemukan';
            $res['result'] = $user;
            return response()->json($res);
        }else{
            $res['success'] = false;
            $res['message'] = 'Data tidak ditemukan!';
            return response()->json($res);
        }
    }


    // show all user
    public function showAllUser(Request $request){
      $users = User::all();
      if ($users) {
          $res['success'] = true;
          $res['message'] = 'Data ditemukan';
          $res['result'] = $users;
          return response()->json($res);
      }else{
          $res['success'] = false;
          $res['message'] = 'Data tidak ditemukan!';
          return response()->json($res);
      }
    }

    // update user by id
    public function updateUserProfile(Request $request, $id){
      $updateUser = User::where('id', $id)->first();
      $updateUser->nama = $request->input('nama');
      $updateUser->email = $request->input('email');
      $updateUser->save();
      if ($updateUser) {
        $res['success'] = true;
        $res['message'] = 'Berhasil update data';
        $res['result'] = $updateUser;
        return response()->json($res);
      }else{
        $res['success'] = false;
        $res['message'] = 'Gagal update data!';
        return response()->json($res);
      }
    }

    // change password
    public function updatePassword(Request $request){
      // Validate all input fields
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
        $res['result'] = $destroyUser;
        return response()->json($res);
      }else{
        $res['success'] = false;
        $res['message'] = 'Gagal menghapus data!';
        return response()->json($res);
      }
    }
}
