<?php

namespace App\Http\Controllers;

use App\Models\Comptoir;
use App\Models\ComptoirProduit;
use App\Models\Produit;
use App\Models\Stock;
use App\Models\VenteComptoir;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VenteComptoirController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      $produits = Produit::select("id","reference","designation","prix_vente")->get();
      $all = [ "produits" => $produits ];
        return view("venteComptoirs.create",$all);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $count_vente = DB::table("vente_comptoirs")->count() + 1;
      $comptoir_id = Comptoir::first()->id;
      $num_vente = "VC-00" . $count_vente;
      $vente_comptoir = VenteComptoir::create([
        "num_vente"   => $num_vente,
        "comptoir_id" => $comptoir_id,
        "remise"      => $request->remise,
        "tva"         => $request->tva,
        "dateVente"   => Carbon::today(),
      ]);
        foreach($request->produits as $k => $val){
          $produit = Produit::find($val);
          // $stock = Stock::where("produit_id",$)
          $montant = $request->qte[$k] * $produit->prix_vente;
          $qte = $request->qte[$k];
          ComptoirProduit::create([
            "produit_id"=>$val,
            "vente_comptoir_id"=>$vente_comptoir->id,
            "quantite"=>$qte,
            "prix"=>$produit->prix_vente,
            "montant"=> $montant
          ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\VenteComptoir  $venteComptoir
     * @return \Illuminate\Http\Response
     */
    public function show(VenteComptoir $venteComptoir)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\VenteComptoir  $venteComptoir
     * @return \Illuminate\Http\Response
     */
    public function edit(VenteComptoir $venteComptoir)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\VenteComptoir  $venteComptoir
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, VenteComptoir $venteComptoir)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\VenteComptoir  $venteComptoir
     * @return \Illuminate\Http\Response
     */
    public function destroy(VenteComptoir $venteComptoir)
    {
        //
    }
}
