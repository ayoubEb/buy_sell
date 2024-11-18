<?php

namespace App\Http\Controllers;

use App\Models\Depense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DepenseController extends Controller
{
      /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
    */

    function __construct()
    {

        $this->middleware('permission:depense-list|depense-nouveau|depense-modification|depense-suppression', ['only' => ['index','show']]);

        $this->middleware('permission:depense-nouveau', ['only' => ['create','store']]);

        $this->middleware('permission:depense-modification', ['only' => ['edit','update']]);

        $this->middleware('permission:depense-suppression', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $depenses = Depense::all();
      $all = [ "depenses" => $depenses ];
      return view("depenses.index",$all);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      $categorieDepenses = DB::table("categorie_depenses")->select("id","nom")->get();
      $all = [ "categorieDepenses" => $categorieDepenses ];
      return view("depenses.create" , $all);
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
        "dateDepense" => ["required"],
      ]);
      Depense::create([
        "categorie_depense_id"         => $request->categorie,
        "statut"      => $request->statut,
        "montant"      => $request->montant,
        "dateDepense"      => $request->dateDepense,
        "description" => $request->description,
      ]);
      Session()->flash("success","L'enregistrement du dépense effectuée");
      return redirect()->route('depense.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Depense  $depense
     * @return \Illuminate\Http\Response
     */
    public function show(Depense $depense)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Depense  $depense
     * @return \Illuminate\Http\Response
     */
    public function edit(Depense $depense)
    {
      $categorieDepenses = DB::table("categorie_depenses")->select("id","nom")->get();
      $all = [
        "categorieDepenses" => $categorieDepenses,
        "depense" => $depense
      ];
      return view("depenses.edit" , $all);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Depense  $depense
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Depense $depense)
    {
      $request->validate([
        "categorie" => ["required"],
        "statut" => ["required"],
        "montant" => ["required","numeric","min:0"],
        "dateDepense" => ["required"],
      ]);
      $depense->update([
        "categorie_depense_id"         => $request->categorie,
        "statut"      => $request->statut,
        "montant"      => $request->montant,
        "dateDepense"      => $request->dateDepense,
        "description" => $request->description,
      ]);
      Session()->flash("success","L'enregistrement du dépense effectuée");
      return redirect()->route('depense.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Depense  $depense
     * @return \Illuminate\Http\Response
     */
    public function destroy(Depense $depense)
    {
      $depense->delete();
      Session()->flash("destroy","La suppression de dépense effectuée");
      return redirect()->route('depense.index');
    }
}
