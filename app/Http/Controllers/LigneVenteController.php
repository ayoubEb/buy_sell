<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\LigneVente;
use App\Models\Produit;
use App\Models\Stock;
use App\Models\StockSuivi;
use App\Models\Vente;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
class LigneVenteController extends Controller
{
  function __construct()
  {
    $this->middleware('permission:ligneVente-list|ligneVente-nouveau|ligneVente-modification', ['only' => ['index','show','newPaiement','now']]);

    $this->middleware('permission:ligneVente-nouveau', ['only' => ['create','store']]);

    $this->middleware('permission:ligneVente-modification', ['only' => ['edit','update']]);

  }
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $commandes   = LigneVente::all();
    $all      = [
      'commandes'=>$commandes,
    ];
    return view('ligneCommandes.index',$all);
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    $produits           = DB::table('produits')->where("quantite",">",0)->whereNull("deleted_at")->get();
    $clients            = DB::table("clients")->select("id","raison_sociale")->whereNull("deleted_at")->get();
    $entreprises        = DB::table("entreprises")->select("id","raison_sociale")->whereNull("deleted_at")->get();
    $tvas               = DB::table("taux_tvas")->pluck("valeur");
    $produits = DB::table('stocks')->join("produits","produits.id","=","stocks.produit_id")
    ->select("produits.prix_vente","produits.reference","produits.id","produits.designation","stocks.disponible","produits.deleted_at","stocks.qte_venteRes")
    ->whereNull("produits.deleted_at")
    ->get();
    $all = [
      'clients'     => $clients,
      "entreprises" => $entreprises,
      "produits"    => $produits,
      "tvas"        => $tvas,
    ];
    return view('ligneCommandes.create',$all);
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
        "client"         => ["required"],
        "remise_facture" => ["required","numeric"],
        "tva"            => ["required","numeric" , "exists:taux_tvas,valeur"],
      ]);
      $count_cmd = LigneVente::withTrashed()->count();
      $reference     = "FAC-" . str_pad($count_cmd + 1, 6, "0", STR_PAD_LEFT);
      $mois          = date("m-Y",strtotime($request->date_facture ?? Carbon::today() ));
      $tva           = DB::table("taux_tvas")->where("valeur",$request->tva)->first()->valeur;
      $ligneVente = LigneVente::create([
        "client_id"     => $request->client,
        "num"           => $reference,
        "statut"        => $request->statut == null ? "en cours" : $request->statut,
        "dateCommande"   => $request->dateCommande != '' ? $request->dateCommande : Carbon::today(),
        "dateCreation"  => Carbon::today(),
        "taux_tva"      => $tva,
        "remise"        => $request->remise_vente ?? 0,
        "entreprise_id" => $request->entreprise_id,
        "payer"         => 0,
        "datePaiement"  => $request->datePaiement,
        "mois"          => $mois,
        'nbrProduits'   => count($request->pro),
        'reste'         => 0,
      ]);
      $sum_qte = 0;
      foreach($request->pro as $k =>  $value)
      {
        $stock      = Stock::where("produit_id",$value)->first();
        $remise_pro = $request->remise[$k] > 0 ? $request->remise[$k] : 0;
        $qte        = $request->qte[$k] ?? 0;
        $price      = $request->price[$k];
        $montant    = $qte * $price;
        $ht         = $montant * ( 1 - ($remise_pro/100));
        if($qte <=( $stock->disponible + $stock->qte_venteRes) ){
          $facturePro = Vente::create([
            "ligne_vente_id"  => $ligneVente->id,
            "produit_id"  => $request->pro[$k],
            "quantite"    => $qte,
            "remise"      => $remise_pro,
            "montant"     => $ht,
            "prix"        => $price,
          ]);
          $sum_qte += $qte;
          $this->saveStock($facturePro->id);
          $stock->update([
            "qte_venteRes" => $stock->qte_venteRes + $qte,
          ]);
        }
      }
      $sum_ht     = Vente::where("ligne_vente_id",$ligneVente->id)->sum("montant");   // sum montants
      $sum_qte    = Vente::where("ligne_vente_id",$ligneVente->id)->sum("quantite");  // sum qte
      $ht_tva     = $sum_ht * (1 + ($tva / 100));                                       // ht tva
      $remise_ht  = $sum_ht * floatval($request->remise_facture / 100);                             // remise ht
      $remise_ttc = floatval($remise_ht) * (1 + ($tva / 100));                          // remise ttc
      $ttc_net    = $ht_tva - $remise_ttc;                                              // net payer
      $ligneVente->update([
        "ttc"         => $ttc_net,
        "ht"          => $sum_ht,
        "qteProduits" => $sum_qte,
        "ht_tva"      => $ht_tva,
        "remise_ht"   => $remise_ht,
        "remise_ttc"  => $ttc_net,
      ]);
      $this->updateClient($ligneVente->client_id);
      // toast("L'enregistrement du facture effectuée","success");
      return redirect()->route("ligneVente.index");

    }


  /**
   * Display the specified resource.
   *
   * @param  \App\Models\LigneVente  $ligneVente
   * @return \Illuminate\Http\Response
  */
  public function show(LigneVente $ligneVente)
  {
    $produits  = $ligneVente->produits()->get();
    $all = [
      "produits"  => $produits,
      "commande"   => $ligneVente,
    ];
    return view("ligneCommandes.show",$all);
  }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\LigneVente  $ligneVente
     * @return \Illuminate\Http\Response
     */
    public function edit(LigneVente $ligneVente)
    {
      if($ligneVente->statut == "validé")
      {
        return back();
      }
      elseif(isset($ligneVente->client ) && $ligneVente->client->deleted_at != null)
      {
        return back();
      }
      else
      {
        $produits      = $ligneVente->produits()->get();
        $clients       = DB::table('clients')->select("id",'raison_sociale')->whereNull("deleted_at")->get();
        $tvas          = DB::table("taux_tvas")->pluck("valeur");

        $all = [
          'commande'  => $ligneVente,
          'produits' => $produits,
          'clients'  => $clients,
          'tvas'  => $tvas,
        ];
        return view('ligneCommandes.edit',$all);

      }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\LigneVente  $ligneVente
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, LigneVente $ligneVente)
    {
      $request->validate([
        "client"         => ["required"],
        "statut"         => ["required"],
        "remise" => ["required","numeric",'min:0'],
        "tva"            => ["required","numeric" , "exists:taux_tvas,valeur"],
      ]);
      $tva         = DB::table("taux_tvas")->where("valeur",$request->tva)->first()->valeur;
      $sum_ht      = Vente::where("ligne_vente_id",$ligneVente->id)->sum("montant");
      $sum_ht      = Vente::where("ligne_vente_id",$ligneVente->id)->sum("montant");        // sum montants
      $ht_tva      = $sum_ht * (1 + ($tva / 100));                                            // ht tva
      $remise_ht   = $sum_ht * floatval($request->remise / 100);                                  // remise ht
      $remise_ttc  = floatval($remise_ht) * (1 + ($tva / 100));                               // remise ttc
      $ttc_net     = $ht_tva - $remise_ttc;                                                   // net payer
     $ligneVente->update([
        "client_id"           => $request->client,
        "statut"              => $request->statut ?? "en cours",
        "remise"              => $request->remise,
        "taux_tva"            => $tva,
        "dateCommande"        => $request->dateCommande,
        "ttc"                 => $ttc_net,
        "reste"               => $ttc_net,
        "ht"                  => $sum_ht,
        "ht_tva"              => $ht_tva,
        "remise_ht"           => $remise_ht,
        "remise_ttc"          => $ttc_net,
      ]);

      return redirect()->route('ligneVente.index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\LigneVente  $ligneVente
     * @return \Illuminate\Http\Response
     */
    public function destroy(LigneVente $ligneVente)
    {
        //
    }


    public function valider(LigneVente $ligneVente , Request $request)
    {
      $ligneVente->update([
        "statut"    => "validé",
        "net_payer" => $ligneVente->ttc,
        "reste" => $ligneVente->ttc,
      ]);

      $ventes = $ligneVente->produits()->get();
      foreach($ventes as $vente)
      {
        $stock = Stock::where("id",$vente->produit_id)->first();
        StockSuivi::create([
          "stock_id"       => $stock->id,
          "quantite"       => $vente->quantite,
          "date_mouvement" => Carbon::today(),
          "fonction"       => "vente_validé",
        ]);



        $stock->update([
          "disponible"=>$stock->disponible - $vente->quantite,
          "sortie"=>$stock->sortie + $vente->quantite,
          "qte_venteRes" => $stock->qte_venteRes - $vente->quantite,
          "qte_vente"    => $stock->qte_vente + $vente->quantite,
        ]);

      }
      $this->updateClient($ligneVente->client_id);
      Session()->flash("valider","");
      return back();
    }


    public function saveStock($vente_id){
      $vente    = Vente::find($vente_id);
      $stock_id = DB::table("stocks")->where("produit_id",$vente->produit_id)->first()->id;
      StockSuivi::create([
        "stock_id"       => $stock_id,
        "quantite"       => $vente->quantite,
        "date_mouvement" => Carbon::now(),
        "fonction"       => "vente_réserver",
      ]);
    }


    public function updateClient($id)
    {
      $client       = Client::find($id);
      $mt_devis     = LigneVente::where("client_id",$client->id)->where("statut","en cours")->sum("ttc");
      $mt_commandes = LigneVente::where("client_id",$client->id)->where("statut","validé")->sum("net_payer");
      $sum_payer    = LigneVente::where("client_id",$client->id)->sum("payer");
      $client->update([
        "montant_devis" => $mt_devis,
        "montant"       => $mt_commandes,
        "reste"         => $mt_commandes,
        "payer"         => $sum_payer
      ]);
    }


}
