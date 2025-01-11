<?php

namespace App\Http\Controllers;

use App\Models\Achat;
use App\Models\LigneAchat;
use App\Models\Stock;
use App\Models\StockSuivi;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
class AchatController extends Controller
{
  function __construct()
  {
    $this->middleware('permission:achat-nouveau', ['only' => ['new','store']]);

    $this->middleware('permission:achat-modification', ['only' => ['edit','update']]);

    $this->middleware('permission:achat-suppression', ['only' => ['destroy']]);

    $this->middleware('permission:achat-display', ['only' => ['show']]);
  }
  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
  */
  public function store(Request $request)
  {
    $ligne     = LigneAchat::find($request->ligne_id);;
    foreach($request->pro as $row => $val)
    {
      $remise_pro = $request->remise[$row] > 0 ? $request->remise[$row] : 0;
      $produit    = DB::table("produits")->where("id",$val)->first();
      $quantite   = $request->quantite[$row] ?? 0;
      $montant    = $quantite * $produit->prix_achat;

      $mt         = $montant * ( 1 - ($remise_pro/100));
      Achat::create([
        "ligne_achat_id" => $ligne->id,
        "produit_id"     => $val,
        "quantite"       => $quantite,
        "remise"         => $remise_pro,
        "montant"        => $mt,
      ]);
      $stock        = DB::table("stocks")->where("produit_id",$produit->id)->exists();
      if($stock == true)
      {
        $stock = DB::table("stocks")->where("produit_id",$produit->id)->first();
        StockSuivi::create([
          "stock_id"       => $stock->id,
          "quantite"       => $quantite,
          "fonction"       => "achat_reserver",
          "date_suivi" => Carbon::today(),
        ]);
      }
      else
      {
        $stock_new = Stock::create([
          "produit_id" => $produit->id,
          "num"        => Str::upper(Str::random(6)),
          "min"        => 0,
        ]);
        StockSuivi::create([
          "stock_id"       => $stock_new->id,
          "quantite"       => $quantite,
          "fonction"       => "achat_reserver",
          "date_suivi" => Carbon::today(),
        ]);
      }

    }
      $ht              = DB::table("achats")->where("ligne_achat_id",$ligne->id)->sum("montant");
      $ttc             = $ht  + ($ht * ($ligne->taux_tva/100));
      $ligne->ttc = $ttc;
      $ligne->ht  = $ht;
      $ligne->reste    = $ttc - $ligne->payer;
      $ligne->save();

      Session()->flash("success","L'enregistrement de produit pour l'achat effectuée");
      return redirect()->route("ligneAchat.edit",["ligneAchat"=>$ligne]);
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\Achat  $achat
   * @return \Illuminate\Http\Response
   */
  public function show(Achat $achat)
  {
      //
  }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Achat  $achat
     * @return \Illuminate\Http\Response
     */
    public function edit(Achat $achat)
    {
      $ligne = LigneAchat::find($achat->ligne_achat_id);
      $all = [
        "achat" => $achat,
        "ligneAchat"=>$ligne
      ];
        return view("achats.edit",$all);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Achat  $achat
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Achat $achat)
    {
      $request->validate([
        "quantite" => ["required","min:1"],
      ]);
      $ph          = DB::table('produits')->where("id",$achat->produit_id)->first()->prix_achat;
      $ligne       = LigneAchat::where("id",$achat->ligne_achat_id)->first();
      // calculer produit
      $montant_remise = ($request->quantite * $ph) * ( 1 - ($request->remise/100));
      $montant        = $request->quantite * $ph;

      // calculer ttc

      $achat->update([
        "quantite" => $request->quantite,
        "remise"   => $request->remise,
        "montant"  => $request->remise == 0 ? $montant : $montant_remise,
      ]);

      $sum_montant = Achat::where("ligne_achat_id",$ligne->id)->sum("montant");
      $ttc = ($sum_montant + ($sum_montant * ($ligne->taux_tva / 100)));
      $ligne->update([
          "ht"  => $sum_montant,
          "ttc" => $ttc,
          "reste"    => $ttc - $ligne->payer,
      ]);

      Session()->flash("update","La modification de produit pour d'achat effectuée");
      return redirect()->route("ligneAchat.edit",["ligneAchat"=>$ligne]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Achat  $achat
     * @return \Illuminate\Http\Response
     */
    public function destroy(Achat $achat)
    {
      $ligne       = LigneAchat::where("id",$achat->ligne_achat_id)->first();
      $sum_montant = Achat::where("ligne_achat_id",$achat->ligne_achat_id)->sum("montant") - $achat->montant;
      $ttc         = $sum_montant + ($sum_montant * ($ligne->taux_tva / 100));
      $ligne->update([
        "ht"  => $sum_montant,
        "ttc" => $ttc,
        "reste"    => $ttc - $ligne->payer
      ]);
      $achat->delete();
      Session()->flash("update","La suppression du produit pour l'achat effectuée");
      return back();
    }


    public function add($id)
    {
      $ligneAchat = LigneAchat::find($id);
      $pro_ids  = DB::table("achats")->where("ligne_achat_id",$id)->whereNull("deleted_at")->pluck("produit_id");
      $produits = DB::table("produits")->select("id","reference","designation","prix_achat","deleted_at")->whereNull("deleted_at")->whereNotIn("id",$pro_ids)->get();
      if($ligneAchat->status == "validé")
      {
        return back();
      }
      elseif(count($produits) === 0 )
      {
        return back();
      }
      else
      {
        $all = [
          "ligneAchat" => $ligneAchat,
          "produits"   => $produits,
        ];
        return view("achats.add",$all);

      }
    }
}
