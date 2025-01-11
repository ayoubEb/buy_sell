<?php

namespace App\Http\Controllers;

use App\Http\Requests\FournisseurRequest;
use App\Models\Fournisseur;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
class FournisseurController extends Controller
{
  function __construct()
  {

    $this->middleware('permission:fournisseur-list', ['only' => 'index']);

    $this->middleware('permission:fournisseur-nouveau', ['only' => ['create','store']]);

    $this->middleware('permission:fournisseur-modification', ['only' => ['edit','update']]);

    $this->middleware('permission:fournisseur-suppression', ['only' => 'destroy']);

    $this->middleware('permission:fournisseur-display', ['only' => 'show']);
  }
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
  */
  public function index()
  {
    $fournisseurs = Fournisseur::select("id","raison_sociale","rc","ice","telephone","fix","email","montant","payer","reste","montant_demande")->get();
    $all          = [ "fournisseurs"=>$fournisseurs ];
    return view("fournisseurs.index",$all);
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
  */
  public function create()
  {
    return view("fournisseurs.create");
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
  */
  public function store(FournisseurRequest $request)
  {
    $request->validated();
    // if(empty($request->raison_sociale) || empty($request->ice) || empty($request->rc) ||   )
    $count_fourni = DB::table("fournisseurs")->count();
    $iden = "for-0".($count_fourni + 1).Str::random(6);
    Fournisseur::create([
      "identifiant"     => Str::upper($iden),
      "raison_sociale"  => $request->raison_sociale,
      "ice"             => $request->ice,
      "rc"              => $request->rc,
      "email"           => $request->email,
      "telephone"       => $request->telephone,
      "fix"             => $request->fix,
      "adresse"         => $request->adresse,
      "ville"           => $request->ville,
      "pays"            => $request->pays,
      "code_postal"     => $request->code_postal,
      "montant"         => 0,
      "payer"           => 0,
      "reste"           => 0,
      "montant_demande"   => 0,
      'moisCreation'            => date("m-Y"),
      "dateCreation"    => Carbon::now(),
    ]);
    return redirect()->route('fournisseur.index')->with("success","L'enregistrement de fournisseur effectuée");
  }


  /**
   * Display the specified resource.
   *
   * @param  \App\Models\Fournisseur  $fournisseur
   * @return \Illuminate\Http\Response
  */
  public function show(Fournisseur $fournisseur)
  {
    $ligneAchats = $fournisseur->ligne_achats()->get();
    $all = [
      "fournisseur" => $fournisseur,
      "ligneAchats" => $ligneAchats,
    ];
    return view("fournisseurs.show",$all);
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Models\Fournisseur  $fournisseur
   * @return \Illuminate\Http\Response
  */
  public function edit(Fournisseur $fournisseur)
  {
    $all = [ "fournisseur" => $fournisseur ];
    return view("fournisseurs.edit",$all);
  }

  /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  \App\Models\Fournisseur  $fournisseur
    * @return \Illuminate\Http\Response
  */
  public function update(Request $request, FournisseurRequest $fournisseur)
  {
    $request->validated();
    $fournisseur->update([
      "raison_sociale"  => $request->raison_sociale,
      "ice"             => $request->ice,
      "rc"              => $request->rc,
      "email"           => $request->email,
      "telephone"       => $request->telephone,
      "fix"             => $request->fix,
      "adresse"         => $request->adresse,
      "ville"           => $request->ville,
      "pays"            => $request->pays,
      "code_postal"     => $request->code_postal,
    ]);
    return redirect()->route('fournisseur.index')->with("success","La modification de fournisseur effectuée");
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\Fournisseur  $fournisseur
   * @return \Illuminate\Http\Response
  */
  public function destroy(Fournisseur $fournisseur,Request $request)
  {
    $fournisseur->delete();
    return back();
  }
}
