<?php

namespace App\Http\Controllers;

use App\Models\TauxTva;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
class TauxTvaController extends Controller
{
  function __construct()
  {
    $this->middleware('permission:tauxTva-list|tauxTva-nouveau|tauxTva-modification', ['only' => ['index']]);

    $this->middleware('permission:tauxTva-nouveau', ['only' => ['create','store']]);

    $this->middleware('permission:tauxTva-modification', ['only' => ['edit','update']]);

    $this->middleware('permission:tauxTva-suppression', ['only' => ['destroy']]);
  }
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $tauxTvas = DB::table("taux_tvas")->get();
    $all              = [ "tauxTvas" => $tauxTvas ];
    return view("tauxTva.index",$all );
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    return view("tauxTva.create");
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    $request->validate([
      "valeur" => ["required","numeric","unique:taux_tvas,valeur"],
      "nom"=>["required"],
    ]);
    TauxTva::create([
      "nom"         => $request->nom,
      "valeur"      => $request->valeur,
      "description" => $request->description,
    ]);

    return redirect()->route('tauxTva.index');
  }



  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Models\TauxTva  $tauxTva
   * @return \Illuminate\Http\Response
   */
  public function edit(TauxTva $tauxTva)
  {
    $all = [ "tauxTva" => $tauxTva ];
    return view("tauxTva.edit",$all );
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\TauxTva  $tauxTva
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, TauxTva $tauxTva)
  {
    $request->validate([
      'valeur' => [
        "required",
        Rule::unique('taux_tvas', 'valeur')->ignore($tauxTva->id),
      ],
      "nom"=>["required"],
    ]);
    $tauxTva->update([
      "valeur"      => $request->valeur,
      "description" => $request->description,
      "nom"         => $request->nom,
    ]);
    return redirect()->route('tauxTva.index');
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\TauxTva  $tauxTva
   * @return \Illuminate\Http\Response
   */
  public function destroy(TauxTva $tauxTva)
  {
    $tauxTva->delete();
    return back();
  }
}
