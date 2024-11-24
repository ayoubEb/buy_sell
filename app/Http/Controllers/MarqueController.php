<?php

namespace App\Http\Controllers;

use App\Models\Marque;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class MarqueController extends Controller
{
  function __construct()
  {
    $this->middleware('permission:marque-list|marque-nouveau|marque-modification', ['only' => ['index']]);

    $this->middleware('permission:marque-nouveau', ['only' => ['create','store']]);

    $this->middleware('permission:marque-modification', ['only' => ['edit','update']]);

    $this->middleware('permission:marque-suppression', ['only' => ['destroy']]);
  }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $marques = DB::table("marques")->whereNull("deleted_at")->get();
      $all              = [ "marques" => $marques ];
      return view("marques.index",$all );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      return view("marques.create");
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
        "nom" => ["required","unique:marques,nom"],
      ]);
      Marque::create([
        "nom"         => $request->nom,
        "statut" => $request->statut == null ? 0 : $request->statut,
      ]);
      return redirect()->route('marque.index');

    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Marque  $marque
     * @return \Illuminate\Http\Response
     */
    public function edit(Marque $marque)
    {
      $all = [ "marque" => $marque ];
      return view("marques.edit",$all );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Marque  $marque
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Marque $marque)
    {
      $request->validate([
        'nom' => [
          "required",
          Rule::unique('marques', 'nom')->ignore($marque->id),
        ],
      ]);
      $marque->update([
        "nom"         => $request->nom,
        "statut" => $request->statut == null ? 0 : $request->statut,
      ]);
      return redirect()->route('tauxTva.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Marque  $marque
     * @return \Illuminate\Http\Response
     */
    public function destroy(Marque $marque)
    {
      $marque->delete();
      return back();
    }
}
