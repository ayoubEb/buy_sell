<?php

namespace App\Http\Controllers;

use App\Exports\LigneAchatCsv;
use App\Exports\LigneAchatXlsx;
use App\Models\Achat;
use App\Models\Entreprise;
use App\Models\Fournisseur;
use App\Models\LigneAchat;
use App\Models\Produit;
use App\Models\Stock;
use App\Models\StockSuivi;
use App\Models\TauxTva;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

class LigneAchatController extends Controller
{

  function __construct()
  {
    $this->middleware('permission:ligneAchat-list|ligneAchat-nouveau|ligneAchat-modification|ligneAchat-display', ['only' => ['index','show']]);

    $this->middleware('permission:ligneAchat-nouveau', ['only' => ['create','store']]);

    $this->middleware('permission:ligneAchat-modification', ['only' => ['edit','valider','update']]);

    $this->middleware('permission:ligneAchat-suppression', ['only' => ['destroy']]);
  }
  /**
      * Display a listing of the resource.
      *
      * @return \Illuminate\Http\Response
  */
  public function index()
  {
    $ligneAchats = LigneAchat::all();
    $all         = [ "ligneAchats"  => $ligneAchats ];
    return view("ligneAchats.index",$all);
  }

  /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
  */
  public function create()
  {
    $fournisseurs = Fournisseur::select("id","raison_sociale")->get();
    $produits     = Produit::select("id","designation","prix_achat","reference")->where("check_depot",1)->get();
    $entreprises  = Entreprise::select("id","raison_sociale")->get();
    $tvas         = TauxTva::select("valeur")->pluck("valeur");

    $all = [
      "fournisseurs" => $fournisseurs,
      "produits"     => $produits,
      "entreprises"  => $entreprises,
      "tvas"         => $tvas,
    ];
    return view("ligneAchats.create",$all);
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
      "fournisseur" => ['required'],
      "statut" => ['required'],
      "datePaiement" => ['required'],
      "tva"         => ['required','numeric','exists:taux_tvas,valeur'],
    ]);
    if(isset($request->pro)){
      $tva         = DB::table("taux_tvas")->where("id",$request->tva)->whereNull("deleted_at")->first();
      $count_achat = LigneAchat::withTrashed()->count();
      $mois        = date("m-Y",strtotime($request->date ?? Carbon::today() ));
      $reference   = "BCMD-" . str_pad($count_achat + 1, 7, "0", STR_PAD_LEFT);
      $ligne = LigneAchat::create([
        "fournisseur_id" => $request->fournisseur,
        "num_achat"      => $reference,
        "statut"         => $request->statut,
        "date_achat"     => $request->date ?? Carbon::today(),
        "taux_tva"       => $request->tva,
        "datePaiement"       => $request->datePaiement,
        "entreprise_id"  => Entreprise::count() > 1 ? Entreprise::first()->id : $request->entreprise_id,
        "payer"          => 0,
        "mois"           => $mois,
        "dateCreation"   => Carbon::today(),
        "nombre_achats"  => count($request->pro),
      ]);
      $tva = $request->tva;
      $ttc = 0;
      foreach($request->pro as $k =>  $value){
        $remise_pro = $request->remise[$k] ?? 0;
        $prix       = $request->prix[$k];
        $qte        = $request->quantite[$k];
        $montant    = $prix * $qte;
        $mt         = $montant * ( 1 - ($remise_pro/100));
        $achat      = Achat::create([
          "ligne_achat_id" => $ligne->id,
          "produit_id"     => $request->pro[$k],
          "quantite"       => $qte,
          "remise"         => $remise_pro,
          "montant"        => $mt,
          "prix"           => $prix,
        ]);
        $this->saveAchat($achat->id);
        $stock = Stock::where("produit_id",$value)->first();
        $stock->update([
          "qte_achatRes"=>$stock->qte_achatRes + $qte,
        ]);
      }
      $ht  = DB::table("achats")->where("ligne_achat_id",$ligne->id)->whereNull("deleted_at")->sum("montant");
      $ttc = $ht  + ($ht * ($tva/100));
      $ht_tva = $ht * ($tva / 100);
      $ligne->update([
          "ttc"    => $ttc,
          "ht"     => $ht,
          "payer"  => 0,
          "reste"  => $ttc,
          "mt_tva" => $ht_tva,
      ]);
      $this->updateFournisseur($ligne->id);
    }
    Session()->flash("success","L'enregistrement d'achat effectuée");
    return redirect()->route('ligneAchat.index');
  }

  public function saveAchat($achat)
  {
    $produitAchat = DB::table("achats")->where("id",$achat)->first();
    $produit      = DB::table("produits")->where("id",$produitAchat->produit_id)->first();
    $stock        = DB::table("stocks")->where("produit_id",$produit->id)->exists();
    if($stock == true)
    {
      $stock = DB::table("stocks")->where("produit_id",$produit->id)->first();
      StockSuivi::create([
        "stock_id"       => $stock->id,
        "quantite"       => $produitAchat->quantite,
        "fonction"       => "achat_reserver",
        "date_suivi" => Carbon::today(),
      ]);
    }
    else
    {
      $stock_new = Stock::create([
        "produit_id" => $produitAchat->produit_id,
        "num"        => Str::upper(Str::random(6)),
        "min"        => 0,
        "max"        => 0,
      ]);
      StockSuivi::create([
        "stock_id"       => $stock_new->id,
        "quantite"       => $produitAchat->quantite,
        "fonction"       => "achat_reserver",
        "date_suivi" => Carbon::today(),
      ]);
    }
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\LigneAchat  $ligneAchat
   * @return \Illuminate\Http\Response
   */
  public function show(LigneAchat $ligneAchat)
  {
    $paiements = $ligneAchat->paiements()->get();
    $achats = $ligneAchat->achats()->get();
    $all = [
      "ligneAchat" => $ligneAchat,
      "paiements"  => $paiements,
      "achats"     => $achats,
    ];
    return view("ligneAchats.show",$all);
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Models\LigneAchat  $ligneAchat
   * @return \Illuminate\Http\Response
   */
  public function edit(LigneAchat $ligneAchat)
  {
    if($ligneAchat->statut == "validé")
    {
      return back();
    }
    elseif($ligneAchat->fournisseur->deleted_at != null)
    {
      return back();
    }
    else
    {
      $pro_ids      = Achat::where("ligne_achat_id",$ligneAchat->id)->pluck("produit_id");
      $count_pro    = Produit::select("id","reference","designation","prix_achat")->whereNotIn("id",$pro_ids)->count();
      $fournisseurs = Fournisseur::select("id","raison_sociale")->get();
      $tvas         = TauxTva::pluck("valeur");
      $entreprises  = Entreprise::select("id","raison_sociale")->get();

      $all = [
        "ligneAchat"   => $ligneAchat,
        "fournisseurs" => $fournisseurs,
        "entreprises"  => $entreprises,
        "tvas"         => $tvas,
        "count_pro"    => $count_pro,
      ];
      return view("ligneAchats.edit",$all);

    }
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\LigneAchat  $ligneAchat
   * @return \Illuminate\Http\Response
  */
  public function update(Request $request, LigneAchat $ligneAchat)
  {
    $request->validate([
      "fournisseur_id" => ["required"],
      "tva"            => ["required"],
      "date_achat"     => ["required"]
    ]);
    $ht  = $ligneAchat->ht;
    $tva = $request->tva;
    $ttc = $ht  + ($ht * ($tva/100));
    $ligneAchat->update([
        "fournisseur_id" => $request->fournisseur_id,
        "status"         => $request->status,
        "taux_tva"       => $request->tva,
        "ttc"            => $ttc,
        "reste"          => $ttc,
        "date_achat"     => $request->date_achat,
        "entreprise_id"  => Entreprise::count() == 1 ? Entreprise::first()->id : $request->entreprise,
    ]);
    return redirect()->route('ligneAchat.index')->with("update","La modification d'achat effectuée");

  }


  public function valider(LigneAchat $ligneAchat) {
    $ligneAchat->update([
      "statut"=>"validé",
      "net_payer"=>$ligneAchat->ttc,
    ]);
    $achats = $ligneAchat->achats()->get();
    foreach($achats as $achat)
    {
      $produit = Produit::find($achat->produit_id);
      $stock = Stock::where("produit_id" ,$achat->produit_id)->first();
      StockSuivi::create([
        "stock_id"       => $stock->id,
        "quantite"       => $achat->quantite,
        "date_suivi" => Carbon::today(),
        "fonction"       => "achat_validé",
      ]);
      $sum_qte = $produit->quantite + $achat->quantite;
      $produit->quantite = $sum_qte;
      $produit->save();
      $stock->update([
        "qte_achat"    => $stock->qte_achat + $achat->quantite,
        "qte_achatRes" => $stock->qte_achatRes - $achat->quantite,
      ]);
    }
    $this->updateFournisseur($ligneAchat->id);
    Session()->flash("update","La modification d'achat effectuée");
    return redirect()->route('ligneAchat.index');
  }

  public function annuler(LigneAchat $ligneAchat) {
    $ligneAchat->update([
      "statut"=>"annuler",
    ]);
    $achats = $ligneAchat->achats()->get();
    foreach($achats as $achat)
    {
      $produit = Produit::find($achat->produit_id);
      $stock = Stock::where("produit_id" ,$achat->produit_id)->first();
      StockSuivi::create([
        "stock_id"       => $stock->id,
        "quantite"       => $achat->quantite,
        "date_suivi" => Carbon::today(),
        "fonction"       => "achat_validé",
      ]);
      $sum_qte = $produit->quantite + $achat->quantite;
      $produit->quantite = $sum_qte;
      $produit->save();
      $stock->update([
        "qte_achatRes" => $stock->qte_achatRes - $achat->quantite,
      ]);
    }
    $this->updateFournisseur($ligneAchat->id);
    Session()->flash("update","La modification d'achat effectuée");
    return redirect()->route('ligneAchat.index');
  }
  public function updateFournisseur($id){
    $ligneAchat = LigneAchat::find($id);
    $mt_demande = LigneAchat::where("fournisseur_id",$ligneAchat->fournisseur_id)->where("statut","en cours")->sum("ttc");
    $mt_facture = LigneAchat::where("fournisseur_id",$ligneAchat->fournisseur_id)->where("statut","validé")->sum("ttc");
    $sum_payer = LigneAchat::where("fournisseur_id",$ligneAchat->fournisseur_id)->sum("payer");
    $fournisseur = Fournisseur::find($ligneAchat->fournisseur_id);
    $fournisseur->update([
      "montant_demande" => $mt_demande,
      "montant"         => $mt_facture,
      "reste"           => $mt_facture,
      "payer"           => $sum_payer
    ]);

  }

  public function demandePrice(LigneAchat $ligneAchat){
    $produits    = $ligneAchat->achats()->get();
    $fournisseur = DB::table("fournisseurs")->where("id",$ligneAchat->fournisseur_id)->first();
    $cssPath     = public_path('build/assets/document-fe395027.css');
    $css         = file_get_contents($cssPath);
    $all = [
      "produits"    => $produits,
      "fournisseur" => $fournisseur,
      "ligneAchat"  => $ligneAchat,
      "css"         => $css
    ];
    $pdf = Pdf::loadview('ligneAchats.demandePrice',$all);
    return $pdf->stream("demande prix : " . $ligneAchat->num_achat);
  }


  public function bon(LigneAchat $ligneAchat){
    $produits      = $ligneAchat->achats()->get();
    $fournisseur = DB::table("fournisseurs")->where("id",$ligneAchat->fournisseur_id)->first();

    $all = [
      "produits"     => $produits,
      "ligneAchat" => $ligneAchat,
      "fournisseur" => $fournisseur,
    ];
    $pdf = Pdf::loadview('ligneAchats.bonCmd',$all);
    return $pdf->stream("bon commande|" . $ligneAchat->num_achat);
  }



  public function exportXlsx(){
    return Excel::download(new LigneAchatXlsx, 'ligneAchats.xlsx');
  }
  public function exportCsv(){
    return Excel::download(new LigneAchatCsv, 'ligneAchats.csv');
  }

  public function document()
  {
    $ligneAchats = LigneAchat::select("id","fournisseur_id","num_achat","statut","ht","ttc" , "net_payer","taux_tva" , "nombre_achats" , "date_achat" , "datePaiement" , "dateCreation" , "payer" ,"mt_tva","reste","mois")->get();
    $all      = [ "ligneAchats" => $ligneAchats ];
    $pdf      = Pdf::loadview('ligneAchats.document',$all);
    $pdf->setPaper("a4","landscape");
    return $pdf->stream("ligneAchats");
  }
}
