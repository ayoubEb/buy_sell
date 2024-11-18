<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
     /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
  */
  function __construct()
  {
    $this->middleware('permission:role-list|role-nouveau|role-modification|role-suppression|role-display', ['only' => ['index']]);

    $this->middleware('permission:role-nouveau', ['only' => ['create','store']]);

    $this->middleware('permission:role-modification', ['only' => ['edit','update']]);

    $this->middleware('permission:role-suppression', ['only' => ['destroy']]);
  }

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
  */
  public function index(Request $request)
  {
    $roles = Role::all();
    $all   = [ "roles" => $roles ];
    return view('roles.index',$all);
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {

    $all  = $this->allPermissions();
    return view('roles.create',$all);
  }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:roles,name',
            'permissions' => 'required',
        ]);
        $role = Role::create(['name' => $request->input('name')]);
        $role->syncPermissions($request->input('permissions'));
        return redirect()->route('role.index')
                        ->with('success','Role created successfully');
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
       $all =  $this->allPermissions($id);
        return view('roles.show',$all);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

      $role_first = Role::first();
      if($role_first != $id)
      {
        $all  = $this->allPermissions($id);

        return view('roles.edit',$all);
      }
      else
      {
        return redirect()->route('role.index');
      }
    }
    public function allPermissions($id = null)
    {
        // $categories = Permission::select('id','name')->where("name","like","categorie-%")->get();

        // $permission = Permission::get();
        $categories       = Permission::where("name","like","categorie-%")->get();
        $stocks           = Permission::where("name","like","stock-%")->get();
        $produits         = Permission::where("name","like","produit-%")->get();
        $users            = Permission::where("name","like","user-%")->get();
        $roles            = Permission::where("name","like","role-%")->get();
        $entreprises      = Permission::where("name","like","entreprise-%")->get();
        $stockSuivis = Permission::where("name","like","stockSuivi-%")->get();
        $ligneAchats      = Permission::where("name","like","ligneAchat-%")->get();
        $achatPaiements   = Permission::where("name","like","achatPaiement-%")->get();
        $fournisseurs     = Permission::where("name","like","fournisseur-%")->get();
        $tauxTvas         = Permission::where("name","like","tauxTva-%")->get();
        if($id != null)
        {
          $role = Role::find($id);
          $rolePermissions = DB::table("role_has_permissions")->where("role_has_permissions.role_id",$role->id)
          ->pluck('role_has_permissions.permission_id','role_has_permissions.permission_id')
          ->all();

        }

        $allAutorisations = [
          "role"             => $role ?? null,
          "rolePermissions"  => $rolePermissions ?? null,
          "categories"       => $categories,
          "stocks"           => $stocks,
          "produits"         => $produits,
          "users"            => $users,
          "roles"            => $roles,
          "entreprises"      => $entreprises,
          "ligneAchats"      => $ligneAchats,
          "stockSuivis"   => $stockSuivis,
          "achatPaiements"   => $achatPaiements,
          "fournisseurs"     => $fournisseurs,
          "tauxTvas"         => $tauxTvas,
        ];


        return $allAutorisations;

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'permissions' => 'required',
        ]);

        $role = Role::find($id);
        $role->name = $request->input('name');
        $role->save();

        $role->syncPermissions($request->input('permissions'));
        return redirect()->route('role.index')
        ->with('update',"la modification d'autorization");

    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table("roles")->where('id',$id)->delete();
        return redirect()->route('role.index')
                        ->with('update',"La suppression d'aurisation effecetuée");
    }
}
