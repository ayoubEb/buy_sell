<?php

namespace App\Http\Controllers;

use App\Models\TauxTva;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Spatie\Activitylog\Models\Activity;

class TauxTvaController extends Controller
{
  function __construct()
  {
    // $this->middleware('permission:tauxTva-list|tauxTva-nouveau|tauxTva-modification', ['only' => ['index']]);
    $this->middleware('permission:tauxTva-list', ['only' => 'index']);

    $this->middleware('permission:tauxTva-nouveau', ['only' => ['create','store']]);

    $this->middleware('permission:tauxTva-modification', ['only' => ['edit','update']]);

    $this->middleware('permission:tauxTva-suppression', ['only' => 'destroy']);

    $this->middleware('permission:tauxTva-suppression', ['only' => 'show']);
  }
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $tauxTvas = TauxTva::select("nom","valeur","description","id")->get();
    $all      = [ "tauxTvas" => $tauxTvas ];
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
    return redirect()->route('tauxTva.index')->with("success","L'enregistrement de taux tva effectuée");
  }


  /**
   * Display the specified resource.
   *
   * @param  \App\Models\TauxTva  $tauxTva
   * @return \Illuminate\Http\Response
  */
  public function show(TauxTva $tauxTva)
  {
    $suivi_actions = $tauxTva->activities()->get();

    foreach($suivi_actions as $suivi_action){
      $user = User::find($suivi_action->causer_id);
      $suivi_action->user = $user ? $user->name : null; // Handle case where user might not be found;
    }
    $all = [
      "tauxTva"       => $tauxTva,
      "suivi_actions" => $suivi_actions,
    ];
    return view("tauxTva.show",$all);
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
    return redirect()->route('tauxTva.index')->with("success","La modification de taux tva effectuée");
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
    return back()->with("success","La suppression de taux tva effectuée");
  }
}
