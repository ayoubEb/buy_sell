<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Spatie\Permission\Models\Role;
class UserController extends Controller
{
  function __construct()
  {
    $this->middleware('permission:user-list|user-nouveau|user-modification|user-display', ['only' => ['index']]);
    $this->middleware('permission:user-nouveau', ['only' => ['create','store']]);
    $this->middleware('permission:user-modification', ['only' => ['edit','update']]);
    $this->middleware('permission:user-suppression', ['only' => ['destroy']]);
  }
  public function index(){
    $users = User::toBase()->get();
    $all = [ "users" => $users ];
    return view("users.index",$all);
  }
  public function create(){
    $roles = Role::pluck('name','name')->all();
    $all = [ "roles" => $roles ];
    return view("users.create",$all);
  }

  public function store(Request $request){
    $request->validate([
       'name'     => ['required'],
       'email'    => ['required','unique:users,email'],
       'password' => ['min:8','confirmed'],
       "roles"    => ["required"],
     ]);

     $user = User::create([
      "image"=>"user.jpg",
      "name"=>$request->name,
      "username"=>$request->username,
      "email"=>$request->email,
      "statut"=>"activer",
      "role"=>$request->fonction ?? "user",
      "password"=>Hash::make($request->password),

  ]);
  $user->assignRole($request->input('roles'));
  Session()->flash("success","L'enregistrement d'utilisateur effectuée");
  return redirect()->route('user.index');
  }

  public function show(User $user)
  {

  }

  public function edit(User $user){
    $roles = Role::pluck('name','name')->all();
    $userRole = $user->roles->pluck('name','name')->all();
    $all = [
      "roles"=>$roles,
      "userRole"=>$userRole,
      "user"=>$user,
    ];
    return view('users.edit',$all);
  }

  public function update(Request $request,User $user){

    $request->validate([
      'name'     => ['required'],
      'email'    => ['required'],
      'roles'    => ['required'],
      'password' => ['nullable','string', 'min:8', 'confirmed']

    ]);
    $user->update([
      "name"     => $request->name,
      "role"     => $request->fonction ?? "user",
      "email"    => $request->email,
      "password" => $request->password ?? '',
    ]);
    DB::table('model_has_roles')->where('model_id',$user->id)->delete();
    $user->assignRole($request->input('roles'));
    Session()->flash("update","La modification d'utilisateur effectuée");
    return redirect()->route('user.index');

  }

  public function destroy(User $user){

    $user->delete();
    Session()->flash("update","La suppression d'utilisateur effectuée");
    return back();
  }

}
