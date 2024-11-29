<?php

namespace App\Http\Controllers;

use App\Models\VenteLivraison;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VenteLivraisonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $venteLivraisons = VenteLivraison::all();
      $all        = [ "vente$venteLivraisons" => $venteLivraisons ];
      return view("vente$venteLivraisons.index",$all);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function add($id)
    {
      $commande = DB::table('ligne_ventes')->where("id",$id)->first();
      if($commande->statut == "validé" && $commande->etat_livraison == 0)
      {
        $livraisons = DB::table("livraisons")->get();
        $all = [
          "commande"         => $commande,
          "livraisons" => $livraisons,
        ];
        return view("venteLivraisons.add",$all);
      }
      else
      {
        return back();
      }
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
        "price"          => ["required",'numeric','min:0'],
        "adresse"        => ["required"],
        "date_livraison" => ['required'],
        "date_depot" => ['required'],
        "livraison_id"   => ['required',"exists:livraisons,id"],
      ]);
      // $count_livraison = VenteLivraison::wit
      $reference      = $num_livraison . $separateur_livraison . str_pad($count_livraison + $counter_livraison, $nbrZero_livraison, "0", STR_PAD_LEFT);
          $start = Carbon::createFromFormat('Y-m-d');
          $end = Carbon::createFromFormat('Y-m-d');
          $delai = $start->diffInDays($end);
          VenteLivraison::create([
            "facture_id"       => $request->facture_id,
            "livraison_id"     => $request->livraison_id,
            "adresse"          => $request->adresse,
            "date_livraison"   => $request->date_livraison,
            "montant"          => $request->price,
            "num_livraison"    => $reference,
          ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\VenteLivraison  $venteLivraison
     * @return \Illuminate\Http\Response
     */
    public function show(VenteLivraison $venteLivraison)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\VenteLivraison  $venteLivraison
     * @return \Illuminate\Http\Response
     */
    public function edit(VenteLivraison $venteLivraison)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\VenteLivraison  $venteLivraison
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, VenteLivraison $venteLivraison)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\VenteLivraison  $venteLivraison
     * @return \Illuminate\Http\Response
     */
    public function destroy(VenteLivraison $venteLivraison)
    {
        //
    }
}
