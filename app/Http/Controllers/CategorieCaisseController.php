<?php

namespace App\Http\Controllers;

use App\Models\CategorieCaisse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CategorieCaisseController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
  */

  function __construct()
  {

        $this->middleware('permission:categorieCaisse-list|categorieCaisse-nouveau|categorieCaisse-modification|categorieCaisse-suppression', ['only' => ['index','show']]);

        $this->middleware('permission:categorieCaisse-nouveau', ['only' => ['create','store']]);

        $this->middleware('permission:categorieCaisse-modification', ['only' => ['edit','update']]);

        $this->middleware('permission:categorieCaisse-suppression', ['only' => ['destroy']]);
  }
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $categorieCaisses = CategorieCaisse::all();
    $all = [ "categorieCaisses" => $categorieCaisses ];
    return view("categorieCaisses.index",$all);
  }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      return view("categorieCaisses.create");
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
      CategorieCaisse::create([
        "nom"         => $request->nom,
        "statut"      => $request->statut,
        "description" => $request->description,
      ]);
      Session()->flash("success","L'enregistrement de catégorie dépense effectuée");
      return redirect()->route('categorieCaisse.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CategorieCaisse  $categorieCaisse
     * @return \Illuminate\Http\Response
     */
    public function show(CategorieCaisse $categorieCaisse)
    {
      $all = [ "categorieCaisse" => $categorieCaisse ];
      return view("categorieCaisses.show",$all);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CategorieCaisse  $categorieCaisse
     * @return \Illuminate\Http\Response
     */
    public function edit(CategorieCaisse $categorieCaisse)
    {
      $all = [ "categorieCaisse" => $categorieCaisse ];
      return view("categorieCaisses.edit",$all);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CategorieCaisse  $categorieCaisse
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CategorieCaisse $categorieCaisse)
    {
      $request->validate([
        'nom' => [
          "required",
          Rule::unique('categorie_caisses', 'nom')->ignore($categorieCaisse->id),
        ],
        "statut"=>["required","in:1,0"]
      ]);
      $categorieCaisse->update([
        "nom"         => $request->nom,
        "statut"      => $request->statut,
        "description" => $request->description,
      ]);
      Session()->flash("success","L'enregistrement de catégorie dépense effectuée");
      return redirect()->route('categorieCaisse.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CategorieCaisse  $categorieCaisse
     * @return \Illuminate\Http\Response
     */
    public function destroy(CategorieCaisse $categorieCaisse)
    {
      $categorieCaisse->delete();
      Session()->flash("destroy","La suppression de catégorie dépense effectuée");
      return redirect()->route('categorieCaisse.index');
    }
}
