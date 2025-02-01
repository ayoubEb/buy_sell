<?php

namespace App\Http\Controllers;

use App\Exports\AchatPaiementCsv;
use App\Exports\AchatPaiementXlsx;
use App\Models\AchatCheque;
use App\Models\AchatPaiement;
use App\Models\Entreprise;
use App\Models\Fournisseur;
use App\Models\LigneAchat;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;

class AchatPaiementController extends Controller
{
  function __construct()
  {
    $this->middleware('permission:achatPaiement-list|achatPaiement-nouveau|achatPaiement-modification|achatPaiement-suppression', ['only' => ['index','show']]);

    $this->middleware('permission:achatPaiement-nouveau', ['only' => ['store' , 'add']]);

    $this->middleware('permission:achatPaiement-modification', ['only' => ['edit','update']]);

    $this->middleware('permission:achatPaiement-suppression', ['only' => ['destroy']]);
  }
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $achatPaiements = AchatPaiement::all();
    $all            = [ "achatPaiements"  => $achatPaiements ];
    return view("achatPaiements.index",$all);
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    $ligne = LigneAchat::where("id",request("ligne_achat_id"))->first();

    $max   = $ligne->reste;
    $request->validate([
      "payer" => ["required","numeric","max:" . $max],
      "type"  => ["required"]
    ]);


    $numero = Str::random(6);
    /**
     * ? save achat paiement
    */

    $count = DB::table("achat_paiements")->count() + 1;

    $achat_paiement = AchatPaiement::create([
      "numero_operation" => Str::upper($numero),
      "ligne_achat_id"   => $ligne->id,
      "num"              => "reçu-0" . $count,
      "payer"            => $request->payer,
      "type_paiement"    => $request->type,
      "date_paiement"    => Carbon::now(),
      "statut"           => $request->type == "espèce" ? "payé" : $request->statusCheque,
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
      AchatCheque::create([
        "achat_paiement_id"=>$achat_paiement->id,
        "numero"           => $request->numero_cheque,
        "banque"           => $banque_nom,
        "date_cheque"      => $request->date_cheque,
        "date_enquisement" => $request->date_enquisement,
      ]);
    }

    $sum_payer = AchatPaiement::where("ligne_achat_id",$ligne->id)->sum("payer");
    $ligne->update([
        "payer"         => $sum_payer,
        "reste"         => $ligne->ttc- $sum_payer,
    ]);
    $this->updateFournisseur($ligne->fournisseur_id);
    return redirect()->route("achatPaiement.minInfo",["achatPaiement" => $achat_paiement]);
  }


  public function updateFournisseur($id)
  {
    $fournisseur = Fournisseur::find($id);
    $sum_payer = LigneAchat::where("fournisseur_id",$fournisseur->id)->where("statut","validé")->sum("payer");
    $sum_total = LigneAchat::where("fournisseur_id",$fournisseur->id)->where("statut","validé")->sum("ttc");
    $fournisseur->update([
      "payer"=>$sum_payer,
      "montant"=>$sum_total,
      "reste"=>$sum_total - $sum_payer,
    ]);
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\AchatPaiement  $achatPaiement
   * @return \Illuminate\Http\Response
   */
  public function show(AchatPaiement $achatPaiement)
  {
    $ligneAchat = DB::table("ligne_achats")->where("id",$achatPaiement->ligne_achat_id)->first();
    $fournisseur = DB::table("fournisseurs")->where("id",$ligneAchat->fournisseur_id)->first();
    $all = [
      "achatPaiement"=>$achatPaiement,
      "ligneAchat"=>$ligneAchat,
      "fournisseur"=>$fournisseur,
    ];
      return view("achatPaiements.show",$all);
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Models\AchatPaiement  $achatPaiement
   * @return \Illuminate\Http\Response
   */
  public function edit(AchatPaiement $achatPaiement)
  {
      $ligneAchat = LigneAchat::where("id",$achatPaiement->ligne_achat_id)->first();
      $banques = DB::table("banques")->select("id","nom")->whereNull("deleted_at")->get();
      $all = [
          "achatPaiement" => $achatPaiement,
          "ligneAchat"    => $ligneAchat,
          "banques"       => $banques,
      ];
      return view("achatPaiements.edit",$all);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\AchatPaiement  $achatPaiement
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, AchatPaiement $achatPaiement)
  {

    $request->validate([
      "payer"=>["required","numeric"]
    ]);

    $ligneAchat = LigneAchat::where("id",$achatPaiement->ligne_achat_id)->first();
    $achatPaiement->update([
      "payer"=>$request->payer,
      "status"=>$request->status ? $request->status : "payé",
    ]);
    if($achatPaiement->type_paiement == "chèque")
    {
      $banque_nom = DB::table("banques")->where("id",$request->banque_cheque)->first()->nom;
      $request->validate([
        'numero_cheque' => [
        "required",
        Rule::unique('achat_cheques', 'numero')->ignore($achatPaiement->cheque->numero),
      ],
        "banque_cheque"    => ["required",'exists:banques,id'],
        "date_cheque"      => ['required','date'],
        "date_enquisement" => ['required','date'],
      ]);
      $banque_nom = DB::table("banques")->where("id",$request->banque_cheque)->first()->nom;
      $achatPaiement->cheque->update([
        "numero"           => $request->numero_cheque,
        "banque"           => $banque_nom,
        "date_cheque"      => $request->date_cheque,
        "date_enquisement" => $request->date_enquisement,
      ]);

    }

    $sum_payer = AchatPaiement::where("ligne_achat_id",$ligneAchat->id)
                ->where('status',"payé")
                ->sum("payer");
    $ligneAchat->update([
      "payer"=>$sum_payer,
      "reste"=>$ligneAchat->ttc - $sum_payer
    ]);
    $this->updateFournisseur($ligneAchat->fournisseur_id);
    Session()->flash("update","La modification du paiement effectuée");
    return redirect()->route('achatPaiement.index');
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\AchatPaiement  $achatPaiement
   * @return \Illuminate\Http\Response
  */
  public function destroy(AchatPaiement $achatPaiement)
  {
    $ligneAchat = LigneAchat::where("id",$achatPaiement->ligne_achat_id)->first();
    $ligneAchat->update([
      "payer"=>$ligneAchat->payer - $achatPaiement->payer,
      "reste"=>$ligneAchat->reste + $achatPaiement->payer,
    ]);

    $achatPaiement->delete();
    Session()->flash("update","La suppression du paiement effectuée");
    return back();
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\FacturePaiement  $facturePaiement
   * @return \Illuminate\Http\Response
  */
  public function minInfo(AchatPaiement $achatPaiement)
  {
    $ligneAchat = LigneAchat::find($achatPaiement->ligne_achat_id);
    $fournisseur = Fournisseur::find($ligneAchat->fournisseur_id);
    $all  = [
      "achatPaiement"=>$achatPaiement,
      "ligneAchat"=>$ligneAchat,
      "fournisseur"=>$fournisseur,
    ];
    Session::flash("sup","");
    return view("achatPaiements.afterSave",$all);
  }

  public function add($id)
  {
    $ligneAchat = LigneAchat::find($id);
    if($ligneAchat->statut == "validé" && $ligneAchat->reste > 0)
    {
      $banques = DB::table("banques")->select("id","nom")->whereNull("deleted_at")->get();
      $all   = [
        "ligneAchat" => $ligneAchat,
        "banques"    => $banques
      ];
      return view("achatPaiements.new",$all);
    }
    else
    {
      return back();
    }
  }


  public function exportXlsx(){
    return Excel::download(new AchatPaiementXlsx, 'achatPaiements.xlsx');
  }
  public function exportCsv(){
    return Excel::download(new AchatPaiementCsv, 'achatPaiements.csv');
  }


  public function document()
  {
    $achatPaiements = AchatPaiement::select("id","ligne_achat_id","statut","num","numero_operation" , "date_paiement","type_paiement")->get();
    $all      = [ "achatPaiements" => $achatPaiements ];
    $pdf      = Pdf::loadview('achatPaiements.document',$all);
    return $pdf->stream("achatPaiements");
  }
}
