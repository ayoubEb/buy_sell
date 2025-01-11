<?php

namespace App\Http\Controllers;

use App\Models\LigneVente;
use App\Models\Produit;
use App\Models\Stock;
use App\Models\StockSuivi;
use App\Models\Vente;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class VenteController extends Controller
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
    public function add($id)
    {
      $commande = LigneVente::find($id);
      if($commande->statut != "validé")
      {
        $pro_ids  = $commande->produits()->pluck("produit_id");
        $produits = DB::table("produits")->join("stocks","produits.id","=","stocks.produit_id")
        ->select("produits.prix_vente","produits.reference","produits.id","produits.designation","stocks.disponible","produits.deleted_at","stocks.qte_venteRes")
        ->whereNotIn("produits.id",$pro_ids)
        ->whereNull("produits.deleted_at")
        ->where("stocks.disponible",">",0)
        ->get();
        $all = [
          "commande" => $commande ,
          "produits" => $produits ,
        ];
        return view("vente.add",$all);
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
      $commande = LigneVente::find($request->commande_id);
      if(isset($request->pro))
      {
        foreach($request->pro as $row => $val){
          $produit = Produit::find($val);
          $qte = $request->qte[$row] ?? 0;
          $stock = Stock::where("produit_id",$val)->first();
          if($qte <= ($stock->disponible - $stock->qte_venteRes))
          {

            $montant = $qte * $request->price[$row];
            StockSuivi::create([
              "stock_id"       => $stock->id,
              "quantite"       => $qte,
              "date_suivi" => Carbon::today(),
              "fonction"       => "vente_réserver",
            ]);
            Vente::create([
              "ligne_vente_id" => $commande->id,
              "produit_id" => $val,
              "quantite"   => $qte,
              "remise"     => $request->remise[$row],
              "montant"    => $montant,
              "prix"       => $request->price[$row],
            ]);
          }
        }
        $tva        = $commande->taux_tva;
        $remise     = $commande->remise;
        $sum_ht     = Vente::where("ligne_vente_id",$commande->id)->sum("montant");
        $sum_qte    = Vente::where("ligne_vente_id",$commande->id)->sum("quantite");
        $ht_tva     = $sum_ht * (1 + ($tva / 100));                                   // ht tva
        $remise_ht  = $sum_ht * floatval($remise / 100);                              // remise ht
        $remise_ttc = floatval($remise_ht) * (1 + ($tva / 100));                      // remise ttc
        $ttc_net    = $ht_tva - $remise_ttc;                                          // net payer
        $commande->update([
          "nbrProduits"    => count($request->pro) + $commande->nbrProduits,
          "ttc"         => $ttc_net,
          "reste"       => $ttc_net,
          "ht"          => $sum_ht,
          "qteProduits" => $sum_qte,
          "ht_tva"      => $ht_tva,
          "remise_ht"   => $remise_ht,
          "remise_ttc"  => $ttc_net,
        ]);
        $stock->update([
          "qte_venteRes"=>$produit->qte_venteRes + $qte,
        ]);
      }
      return redirect()->route('ligneVente.edit',["ligneVente"=>$commande]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Vente  $vente
     * @return \Illuminate\Http\Response
     */
    public function show(Vente $vente)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Vente  $vente
     * @return \Illuminate\Http\Response
     */
    public function edit(Vente $vente)
    {
      $produit = DB::table("produits")->whereNull("deleted_at")->where("id",$vente->produit_id)->first();
      $stock = DB::table("stocks")->whereNull("deleted_at")->where("produit_id",$produit->id)->first();
      $all = [
        "vente" => $vente,
        "produit"=>$produit,
        "stock"=>$stock,
      ];
      return view("vente.edit",$all);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Vente  $vente
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Vente $vente)
    {

      $commande        = LigneVente::find($vente->ligne_vente_id);
      $stock        = Stock::find($vente->produit_id);
      $tva            = $commande->taux_tva;
      $pv = $vente->prix;
      $qte            = $request->quantite ?? 0;
      $remise         = $request->remise ?? 0;
      $montant = ($qte *  $pv) * ( 1 - ($remise/100));
      $qte_vente = $stock->qte_venteRes - $vente->quantite;
      $vente->update([
          "quantite" => $qte,
          "remise"   => $remise,
          "montant"  => $montant,
      ]);

      $sum_ht      = Vente::where("ligne_vente_id",$vente->id)->sum("montant");
      $sum_qte     = Vente::where("ligne_vente_id",$vente->id)->sum("quantite");
      $sum_nbrs    = Vente::where("ligne_vente_id",$vente->id)->count();
      $tva         = $commande->taux_tva;
      $remiseCommande = $commande->remise;
      $ht_tva      = $sum_ht * (1 + ($tva / 100));                                       // ht tva
      $remise_ht   = $sum_ht * floatval($remiseCommande / 100);                             // remise ht
      $remise_ttc  = floatval($remise_ht) * (1 + ($tva / 100));                          // remise ttc
      $ttc_net     = $ht_tva - $remise_ttc;

      $commande->update([
        "ttc"         => $ttc_net,
        "reste"       => $ttc_net,
        "ht"          => $sum_ht,
        "qteProduits" => $sum_qte,
        "nbrProduits" => $sum_nbrs,
        "ht_tva"      => $ht_tva,
        "remise_ht"   => $remise_ht,
        "remise_ttc"  => $ttc_net,
      ]);
      $stock->update([
        "qte_venteRes"=>$qte_vente + $qte,
      ]);
      StockSuivi::create([
        "quantite"=>$vente->quantite,
        "fonction"=>"modification du produit " . $stock->produit->reference . " de vente",
      ]);
      return redirect()->route('ligneVente.edit',["ligneVente"=>$commande]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Vente  $vente
     * @return \Illuminate\Http\Response
     */
    public function destroy(Vente $vente)
    {
      $commande  = LigneVente::find($vente->ligne_vente_id);
      $sum_ht   = Vente::where("ligne_vente_id",$commande->id)->sum("montant") - $vente->montant;
      $sum_qte  = Vente::where("ligne_vente_id",$commande->id)->sum("quantite");
      $sum_nbrs = Vente::where("ligne_vente_id",$commande ->id)->count();
      $tva         = $commande->taux_tva;
      $remiseCommande = $commande->remise;
      $ht_tva      = $sum_ht * (1 + ($tva / 100));                                       // ht tva
      $remise_ht   = $sum_ht * floatval($remiseCommande / 100);                             // remise ht
      $remise_ttc  = floatval($remise_ht) * (1 + ($tva / 100));                          // remise ttc
      $ttc_net     = $ht_tva - $remise_ttc;

      $commande->update([
        "ttc"         => $ttc_net,
        "reste"       => $ttc_net,
        "ht"          => $sum_ht,
        "qteProduits" => $sum_qte,
        "nbrProduits" => $sum_nbrs,
        "ht_tva"      => $ht_tva,
        "remise_ht"   => $remise_ht,
        "remise_ttc"  => $ttc_net,
      ]);

      $stock = Stock::where("produit_id",$vente->produit_id)->first();
      $stock->update([
        "qte_venteRes"=>$stock->qte_venteRes - $vente->quantite,
      ]);
      $vente->delete();
      Session()->flash("destroy","");
      return back();
    }
}
