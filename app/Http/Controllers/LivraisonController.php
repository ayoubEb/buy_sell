<?php

namespace App\Http\Controllers;

use App\Models\Livraison;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;

class LivraisonController extends Controller
{
  function __construct()
  {
    $this->middleware('permission:livraison-list|livraison-nouveau|livraison-modification|livraison-display', ['only' => ['index','show']]);

    $this->middleware('permission:livraison-nouveau', ['only' => ['create','store']]);

    $this->middleware('permission:livraison-modification', ['only' => ['edit','update']]);

    $this->middleware('permission:livraison-suppression', ['only' => ['destroy']]);
  }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $livraisons = DB::table('livraisons')->get();
      $all = [ "livraisons" => $livraisons ];
      return view("livraisons.index",$all);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      return view("livraisons.create");
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
        "prix"           => ["required","numeric"],
        "libelle"         => ["required"],
        "ville"          => ["required",'unique:livraisons,ville'],
      ]);
      Livraison::create([
        "prix"           => $request->prix,
        "libelle"         => $request->libelle,
        "ville"          => $request->ville,
      ]);
      Session()->flash("success","L'enregistrement de livraison effectuée");
      return redirect()->route('livraison.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Livraison  $livraison
     * @return \Illuminate\Http\Response
     */
    public function show(Livraison $livraison)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Livraison  $livraison
     * @return \Illuminate\Http\Response
     */
    public function edit(Livraison $livraison)
    {
      $all = [ "livraison" => $livraison ];
      return view("livraisons.edit",$all);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Livraison  $livraison
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Livraison $livraison)
    {
      $request->validate([
        "prix"           => ["required","numeric"],
        "libelle"         => ["required"],
        'ville' => [
          "required",
          Rule::unique('livraisons', 'ville')->ignore($livraison->id),
        ],
      ]);
      $livraison->update([
        "prix"           => $request->prix,
        "libelle"         => $request->libelle,
        "ville"          => $request->ville,
      ]);
      Session()->flash("update","La modification de livraison effectuée");
      return redirect()->route('livraison.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Livraison  $livraison
     * @return \Illuminate\Http\Response
     */
    public function destroy(Livraison $livraison)
    {
      $livraison->delete();
      Session()->flash("success","La suppression de livraison effectuée");
      return back();
    }


    public function livraisonPrice()
    {
      $id = intval(request("id"));
      $price = DB::table("livraisons")->where("id",$id)->first()->prix;
      return $price;
    }
}
