<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Entreprise;
use App\Models\LigneVente;
use App\Models\Produit;
use App\Models\Stock;
use App\Models\StockSuivi;
use App\Models\Vente;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
class LigneVenteController extends Controller
{
  function __construct()
  {
    $this->middleware('permission:ligneVente-list|ligneVente-nouveau|ligneVente-modification|ligneVente-display', ['only' => ['index','show']]);

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
    foreach($commandes as $commande)
    {
      $today = Carbon::today();
      $toDate       = Carbon::parse($today);
      $fromDate     = Carbon::parse($commande->datePaiement);
      $commande->delai = $toDate->diffInDays($fromDate);
    }
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
      "datePaiement"   => ["required","date"],
      "tva"            => ["required","numeric" , "exists:taux_tvas,valeur"],
    ]);
    $count_cmd = LigneVente::withTrashed()->count();
    $reference = "FAC-" . str_pad($count_cmd + 1, 6, "0", STR_PAD_LEFT);
    $mois      = date("m-Y",strtotime($request->date_facture ?? Carbon::today() ));
    $tva       = DB::table("taux_tvas")->where("valeur",$request->tva)->first()->valeur;
    $ligneVente = LigneVente::create([
      "client_id"     => $request->client,
      "num"           => $reference,
      "statut"        => $request->statut == null ? "en cours" : $request->statut,
      "dateCommande"   => $request->dateCommande != '' ? $request->dateCommande : Carbon::today(),
      "dateCreation"  => Carbon::today(),
      "taux_tva"      => $tva,
      "remise"        => $request->remise_vente ?? 0,
      "entreprise_id" => Entreprise::count() == 1 ? Entreprise::first()->id : $request->entreprise_id,
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
    $ht_tva     = $sum_ht * (1 + ($tva / 100));                                     // ht tva
    $remise_ht  = $sum_ht * floatval($request->remise_facture / 100);               // remise ht
    $remise_ttc = floatval($remise_ht) * (1 + ($tva / 100));                        // remise ttc
    $ttc_net    = $ht_tva - $remise_ttc;                                            // net payer
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
    Session::flash("success","L'enregistrement de vente effectuée");
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
        "date_suivi" => Carbon::today(),
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
      "date_suivi" => Carbon::now(),
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


  public function devis(LigneVente $ligneVente){

    $entreprise     = $ligneVente->entreprise;
    $produits = $ligneVente->produits()->get();
    $client = DB::table("clients")->where("id",$ligneVente->client_id)->first();

    $all = [
      "commande"        => $ligneVente,
      "client"        => $client,
      "produits"        => $produits,
      "entreprise"      => $entreprise ?? null,
    ];
    $pdf = Pdf::loadview('ligneCommandes.devis',$all);
    return $pdf->stream("devis : " . $ligneVente->num);
    // return $pdf->download('facture.pdf');
  }

  public function facture_preforma(LigneVente $ligneVente){

    $entreprise     = $ligneVente->entreprise;
    $produits = $ligneVente->produits()->get();
    $client = DB::table("clients")->where("id",$ligneVente->client_id)->first();

    $all = [
      "commande"        => $ligneVente,
      "client"        => $client,
      "produits"        => $produits,
      "entreprise"      => $entreprise ?? null,
    ];
    $pdf = Pdf::loadview('ligneCommandes.preforma',$all);
    return $pdf->stream("devis : " . $ligneVente->num);
  }


  public function facture(LigneVente $ligneVente){

    $client = DB::table("clients")->where("id",$ligneVente->client_id)->first();
    $entreprise     = $ligneVente->entreprise;
    $letter_chiffre = $this->asLetters(($ligneVente->net_payer));
    $produits = $ligneVente->produits()->get();
    $all = [
      "commande"        => $ligneVente,
      "entreprise"      => $entreprise ?? null,
      "letter_chiffre" => $letter_chiffre,
      "produits" => $produits,
      "client"        => $client,
    ];
    $pdf = Pdf::loadview('ligneCommandes.facture',$all);
    return $pdf->stream("facture:".$ligneVente->num);
    // return $pdf->download('facture.pdf');
  }


  public static function asLetters($number) {
    $convert = explode('.', $number);
    $num[17] = array('zero', 'un', 'deux', 'trois', 'quatre', 'cinq', 'six', 'sept', 'huit',
    'neuf', 'dix', 'onze', 'douze', 'treize', 'quatorze', 'quinze', 'seize');

    $num[100] = array(20 => 'vingt', 30 => 'trente', 40 => 'quarante', 50 => 'cinquante',
    60 => 'soixante', 70 => 'soixante-dix', 80 => 'quatre-vingt', 90 => 'quatre-vingt-dix');

    if (isset($convert[1]) && $convert[1] != '') {
    return self::asLetters($convert[0]).' et '.self::asLetters($convert[1]);
    }
    if ($number < 0) return 'moins '.self::asLetters(-$number);
    if ($number < 17) {
    return $num[17][$number];
    }
    elseif ($number < 20) {
    return 'dix-'.self::asLetters($number-10);
    }
    elseif ($number < 100) {
    if ($number%10 == 0) {
    return $num[100][$number];
    }
    elseif (substr($number, -1) == 1) {
    if( ((int)($number/10)*10)<70 ){
    return self::asLetters((int)($number/10)*10).'-et-un';
    }
    elseif ($number == 71) {
    return 'soixante-et-onze';
    }
    elseif ($number == 81) {
    return 'quatre-vingt-un';
    }
    elseif ($number == 91) {
    return 'quatre-vingt-onze';
    }
    }
    elseif ($number < 70) {
    return self::asLetters($number-$number%10).'-'.self::asLetters($number%10);
    }
    elseif ($number < 80) {
    return self::asLetters(60).'-'.self::asLetters($number%20);
    }
    else {
    return self::asLetters(80).'-'.self::asLetters($number%20);
    }
    }
    elseif ($number == 100) {
    return 'cent';
    }
    elseif ($number < 200) {
    return self::asLetters(100).' '.self::asLetters($number%100);
    }
    elseif ($number < 1000) {
    return self::asLetters((int)($number/100)).' '.self::asLetters(100).($number%100 > 0 ? ' '.self::asLetters($number%100): '');
    }
    elseif ($number == 1000){
    return 'mille';
    }
    elseif ($number < 2000) {
    return self::asLetters(1000).' '.self::asLetters($number%1000).' ';
    }
    elseif ($number < 1000000) {
    return self::asLetters((int)($number/1000)).' '.self::asLetters(1000).($number%1000 > 0 ? ' '.self::asLetters($number%1000): '');
    }
    elseif ($number == 1000000) {
    return 'millions';
    }
    elseif ($number < 2000000) {
    return self::asLetters(1000000).' '.self::asLetters($number%1000000);
    }
    elseif ($number < 1000000000) {
    return self::asLetters((int)($number/1000000)).' '.self::asLetters(1000000).($number%1000000 > 0 ? ' '.self::asLetters($number%1000000): '');
    }
  }


}
