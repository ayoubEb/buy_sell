<?php

namespace App\Http\Controllers;

use App\Models\Produit;
use App\Models\Stock;
use App\Models\StockSuivi;
use Carbon\Carbon;
use Illuminate\Http\Request;

class StockSuiviController extends Controller
{
  function __construct()
  {

    $this->middleware('permission:stockSuivi-nouveau', ['only' => ['resign','store']]);

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
        "stock"    => ['required','exists:stocks,id'],
        "qte_add" => ['required','numeric','min:1'],
      ]);
      $stock     = Stock::find($request->stock);
      $produit = Produit::find($stock->produit_id);
      StockSuivi::create([
        "stock_id"       => $stock->id,
        "fonction"       => "augmentation",
        "quantite"       => $request->qte_add,
        "date_mouvement" => Carbon::today(),
      ]);
      $qte_new                = $produit->quantite + $request->qte_add;
      $produit->quantite      = $qte_new;
      $produit->qte_augmenter = $request->qte_add;
      $produit->save();
      Session()->flash("success","L'augmentation du stock effectuée");
      return back();
    }

      /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function resign($id,Request $request)
  {
    $request->validate([
      "qte_demi"=>["required","numeric","min:1"]
    ]);
    $stock   = Stock::find($id);
    $produit = Produit::find($stock->produit_id);
    $produit->update([
      "quantite" => $produit->quantite - intval(request("qte_demi")),
    ]);
    $stock->update([
      "disponible"=>$stock->disponible - intval($request("qte_demi")),
    ]);
    StockSuivi::create([
      "stock_id"       => $stock->id,
      "fonction"       => "démissionner",
      "quantite"       => request("qte_demi"),
      "date_mouvement" => Carbon::today(),
    ]);
    Session()->flash("success","Démessionner du stock effectuée");
    return back();
  }
}
