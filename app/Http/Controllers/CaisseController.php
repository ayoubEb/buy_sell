<?php

namespace App\Http\Controllers;

use App\Models\Caisse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CaisseController extends Controller
{
  function __construct()
  {
    $this->middleware('permission:caisse-list|caisse-nouveau|caisse-modification|caisse-suppression', ['only' => ['index','show']]);

    $this->middleware('permission:caisse-nouveau', ['only' => ['create','store']]);

    $this->middleware('permission:caisse-modification', ['only' => ['edit','update']]);

    $this->middleware('permission:caisse-suppression', ['only' => ['destroy']]);

  }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $caisses = Caisse::all();
      $all = [ "caisses" => $caisses ];
      return view("caisses.index",$all);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      $categorieCaisses = DB::table("categorie_caisses")->select("id","nom")->get();
      $all = [ "categorieCaisses" => $categorieCaisses ];
      return view("caisses.create" , $all);
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
        "categorie" => ["required"],
        "statut" => ["required"],
        "montant" => ["required","numeric","min:0"],
        "dateCaisse" => ["required"],
        "operation" => ["required"],
      ]);
      Caisse::create([
        "categorie_caisse_id"         => $request->categorie,
        "statut"      => $request->statut,
        "montant"      => $request->montant,
        "dateCaisse"      => $request->dateCaisse,
        "operation" => $request->operation,
        "observation" => $request->observation,
      ]);
      Session()->flash("success","L'enregistrement du dépense effectuée");
      return redirect()->route('caisse.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Caisse  $caisse
     * @return \Illuminate\Http\Response
     */
    public function show(Caisse $caisse)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Caisse  $caisse
     * @return \Illuminate\Http\Response
     */
    public function edit(Caisse $caisse)
    {
      $categorieCaisses = DB::table("categorie_caisses")->select("id","nom")->get();
      $all = [
        "categorieCaisses" => $categorieCaisses,
        "caisse" => $caisse
      ];
      return view("caisses.edit" , $all);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Caisse  $caisse
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Caisse $caisse)
    {
      $request->validate([
        "categorie" => ["required"],
        "statut" => ["required"],
        "montant" => ["required","numeric","min:0"],
        "dateCaisse" => ["required"],
        "operation" => ["required"],
      ]);
      $caisse->update([
        "categorie_caisse_id"         => $request->categorie,
        "statut"      => $request->statut,
        "montant"      => $request->montant,
        "operation"      => $request->operation,
        "dateCaisse"      => $request->dateCaisse,
        "observation" => $request->observation,
      ]);
      Session()->flash("success","L'enregistrement du dépense effectuée");
      return redirect()->route('depense.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Caisse  $caisse
     * @return \Illuminate\Http\Response
     */
    public function destroy(Caisse $caisse)
    {
      $caisse->delete();
      Session()->flash("destroy","La suppression de dépense effectuée");
      return redirect()->route('depense.index');
    }
}
