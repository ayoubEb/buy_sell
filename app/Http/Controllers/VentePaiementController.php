<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\LigneVente;
use App\Models\VenteCheque;
use App\Models\VentePaiement;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;

class VentePaiementController extends Controller
{
  function __construct()
  {
       $this->middleware('permission:ventePaiement-list|ventePaiement-nouveau|ventePaiement-modification|ventePaiement-suppression', ['only' => ['index','show']]);
       $this->middleware('permission:ventePaiement-nouveau', ['only' => 'store']);
       $this->middleware('permission:ventePaiement-modification', ['only' => ['edit','update']]);
       $this->middleware('permission:ventePaiement-suppression', ['only' => ['destroy']]);
  }
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $ventePaiements = VentePaiement::all();
    $all               = [ "ventePaiements"=>$ventePaiements ];
    return view("ventePaiements.index",$all);
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function add($id)
  {
    $commande = LigneVente::find($id);
    if($commande->statut == "validé" && $commande->reste > 0)
    {
      $banques = DB::table("banques")->select("id","nom")->whereNull("deleted_at")->get();
      $all   = [
        "commande" => $commande,
        "banques" => $banques,
      ];
      return view("ventePaiements.new",$all);
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
    $commande = LigneVente::where("id",$request->commande_id)->first();
    $max   =  $commande->reste;
    $request->validate([
      "payer" => ["required","numeric","max:" . $max],
      "type"  => ["required","in:espèce,chèque"]
    ]);
    $count = VentePaiement::count() + 1;
    $num = "reçu-0".$count;
    $commande_ex = LigneVente::where("id",$request->commande_id)->exists();
    if($commande_ex == true)
    {

      $vente_paiement = VentePaiement::create([
        "ligne_vente_id"       => $commande->id,
        "num"       => $num,
        "numero_operation" => rand(),
        "payer"            => $request->payer,
        "type_paiement"    => $request->type,
        "date_paiement"    => Carbon::now(),
        "statuT"=>$request->type == "espèce" ? "payé" : "impayé",
      ]);

      if($request->type == "chèque")
      {
        $request->validate([
          "numero_cheque"    => ['required','unique:achat_cheques,numero'],
          "banque_cheque"    => ["required",'exists:banques,id'],
          "date_cheque"      => ['required','date'],
          "date_enquisement" => ['required','date'],
        ]);
        $banque_nom = DB::table("banques")->where("id",$request->banque_cheque)->first()->nom;
        VenteCheque::create([
          "vente_paiement_id"=>$vente_paiement->id,
          "numero"           => $request->numero_cheque,
          "banque"           => $banque_nom,
          "date_cheque"      => $request->date_cheque,
          "date_enquisement" => $request->date_enquisement,
        ]);
      }

      $commande->update([
        "payer"         => $commande->payer + $request->payer,
        "reste"         => $commande->reste - $request->payer,
      ]);

      $this->updateClient($commande->id);
      if($commande->reste == 0){
        Session()->flash("sup","");
        return redirect()->route('ligneVente.show',["ligneVente"=>$commande]);
      }
      else
      {
        return redirect()->route("ventePaiement.minInfo",["ventePaiement" => $vente_paiement]);
      }
    }
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\VentePaiement  $ventePaiement
   * @return \Illuminate\Http\Response
   */
  public function show(VentePaiement $ventePaiement)
  {
    $commande = LigneVente::find($ventePaiement->ligne_vente_id);
    $client  = Client::find($commande->client_id);
    $all = [
      "ventePaiement" => $ventePaiement,
      "client"          => $client,
      "commande"          => $commande
    ];
    return view("ventePaiements.show",$all);
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Models\VentePaiement  $ventePaiement
   * @return \Illuminate\Http\Response
   */
  public function edit(VentePaiement $ventePaiement)
  {
    $commande = LigneVente::find($ventePaiement->ligne_vente_id);
    $banques = DB::table("banques")->select("id","nom")->whereNull("deleted_at")->get();
    $all = [
        "ventePaiement" => $ventePaiement,
        "commande"         => $commande,
        "banques"         => $banques,
    ];
    return view("ventePaiements.edit",$all);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\VentePaiement  $ventePaiement
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, VentePaiement $ventePaiement)
  {
    $request->validate([
      "payer"=>["required","numeric"]
    ]);

    $commande = LigneVente::where("id",$ventePaiement->ligne_vente_id)->first();
    $mt_payer_avant = $commande->payer - $ventePaiement->payer;
    $mt_reste_avant = $commande->reste + $ventePaiement->payer;
    $ventePaiement->update([
      "payer"  => $request->payer,
      "statut" => $request->statut ? $request->statut : "payé",
    ]);
    if($ventePaiement->type_paiement == "chèque")
    {
      $banque_nom = DB::table("banques")->where("id",$request->banque_cheque)->first()->nom;
      $request->validate([
        'numero_cheque' => [
        "required",
        Rule::unique('vente_cheques', 'numero')->ignore($ventePaiement->cheque->numero),
      ],
        "banque_cheque"    => ["required",'exists:banques,id'],
        "date_cheque"      => ['required','date'],
        "date_enquisement" => ['required','date'],
      ]);
      $banque_nom = DB::table("banques")->where("id",$request->banque_cheque)->first()->nom;
      $ventePaiement->cheque->update([
        "numero"           => $request->numero_cheque,
        "banque"           => $banque_nom,
        "date_cheque"      => $request->date_cheque,
        "date_enquisement" => $request->date_enquisement,
      ]);

    }
    $commande->update([
        "payer"=>$mt_payer_avant + $request->payer,
        "reste"=>$mt_reste_avant - $request->payer,
    ]);

    $this->updateClient($commande->client_id);

      return redirect()->route('ventePaiement.index');

  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\VentePaiement  $ventePaiement
   * @return \Illuminate\Http\Response
   */
  public function destroy(VentePaiement $ventePaiement)
  {
    $commande = LigneVente::where("id",$ventePaiement->ligne_vente_id)->first();
    $commande->update([
        "payer"=>$commande->payer - $ventePaiement->payer,
        "reste"=>$commande->reste + $ventePaiement->payer,
    ]);
    $ventePaiement->delete();
    Session::flash("sup","");
    return back();
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\VentePaiement  $facturePaiement
   * @return \Illuminate\Http\Response
  */
  public function minInfo(VentePaiement $ventePaiement)
  {
    $commande = LigneVente::find($ventePaiement->ligne_vente_id);
    $client = Client::find($commande->client_id);
    $all  = [
      "ventePaiement"=>$ventePaiement,
      "commande"=>$commande,
      "client"=>$client,
    ];
    Session::flash("sup","");
    return view("ventePaiements.afterSave",$all);
  }

  public function updateClient($id)
  {
    $mt_devis = LigneVente::where("client_id",$id)->where("statut","en cours")->sum("net_payer");
    $mt_facture = LigneVente::where("client_id",$id)->where("statut","validé")->sum("net_payer");
    $sum_payer = LigneVente::where("client_id",$id)->sum("payer");
    $client = Client::find($id);
    $client->update([
      "montant_devis"=>$mt_devis,
      "montant"=>$mt_facture,
      "reste"=>$mt_facture,
      "payer"=>$sum_payer
    ]);
  }
}
