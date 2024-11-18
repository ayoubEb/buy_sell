<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class ProfilController extends Controller
{
    public function monCompte($id){
      $user = User::find($id);
      $all = [ "user" => $user ];
      return view("profils.monCompte",$all);
    }
    public function edit($id){
      $user = User::find($id);
      $all = [ "user" => $user ];
      return view("profils.preference",$all);
    }

    public function update(Request $request,$id){

      $request->validate([
          'name'=>['required'],
          'email'=>['required'],
          'password' => ['nullable','string', 'confirmed','max:8']
        ]);
        $user = User::find($id);
        $user->update([
          "name"=>$request->name,
          "email"=>$request->email,
          "password"=>Hash::make($request->password) ?? "",
        ]);
        Session()->flash("update","La modification de profil effectuée");
        return back();

}
}
