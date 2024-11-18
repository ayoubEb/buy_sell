<?php

namespace App\Http\Controllers;

use App\Models\CategorieDepense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;

class CategorieDepenseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
    */

    function __construct()
    {

        $this->middleware('permission:categorieDepense-list|categorieDepense-nouveau|categorieDepense-modification|categorieDepense-suppression', ['only' => ['index','show']]);

        $this->middleware('permission:categorieDepense-nouveau', ['only' => ['create','store']]);

        $this->middleware('permission:categorieDepense-modification', ['only' => ['edit','update']]);

        $this->middleware('permission:categorieDepense-suppression', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $categorieDepenses = CategorieDepense::all();
      $all = [ "categorieDepenses" => $categorieDepenses ];
      return view("categorieDepenses.index",$all);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      return view("categorieDepenses.create");
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
        "nom" => ["required","unique:categories,nom"],
        "statut" => ["required"],
      ]);
      CategorieDepense::create([
        "nom"         => $request->nom,
        "statut"      => $request->statut,
        "description" => $request->description,
      ]);
      Session()->flash("success","L'enregistrement de catégorie dépense effectuée");
      return redirect()->route('categorieDepense.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CategorieDepense  $categorieDepense
     * @return \Illuminate\Http\Response
     */
    public function show(CategorieDepense $categorieDepense)
    {
      $all = [ "categorieDepense" => $categorieDepense ];
      return view("categorieDepenses.show",$all);
      //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CategorieDepense  $categorieDepense
     * @return \Illuminate\Http\Response
     */
    public function edit(CategorieDepense $categorieDepense)
    {
      $all = [ "categorieDepense" => $categorieDepense ];
      return view("categorieDepenses.edit",$all);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CategorieDepense  $categorieDepense
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CategorieDepense $categorieDepense)
    {
      $request->validate([
        'nom' => [
          "required",
          Rule::unique('categorie_depenses', 'nom')->ignore($categorieDepense->id),
        ],
        "statut"=>["required","in:1,0"]
      ]);
      $categorieDepense->update([
        "nom"         => $request->nom,
        "statut"      => $request->statut,
        "description" => $request->description,
      ]);
      Session()->flash("success","L'enregistrement de catégorie dépense effectuée");
      return redirect()->route('categorieDepense.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CategorieDepense  $categorieDepense
     * @return \Illuminate\Http\Response
     */
    public function destroy(CategorieDepense $categorieDepense)
    {
      $categorieDepense->delete();
      Session()->flash("destroy","La suppression de catégorie dépense effectuée");
      return redirect()->route('categorieDepense.index');
    }
}
