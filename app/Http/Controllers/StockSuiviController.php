<?php

namespace App\Http\Controllers;

use App\Models\Depot;
use App\Models\DepotSuivi;
use App\Models\Produit;
use App\Models\Stock;
use App\Models\StockDepot;
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
      $qte_add = $request->qte_add;
      $stock     = Stock::find($request->stock);
      $stock->update([
        "disponible"    => $stock->disponible + $qte_add,
        "quantite"      => $stock->quantite + $qte_add,
        "reste"         => $stock->reste + $qte_add,
        "qte_augmenter" => $stock->qte_augmenter + $qte_add,
      ]);
      StockSuivi::create([
        "stock_id"       => $stock->id,
        "fonction"       => "augmentation",
        "quantite"       => $qte_add,
        "date_suivi" => Carbon::today(),
      ]);
      $depot = null;

      if(isset($request->depot_add)){
        $depot = Depot::find($request->depot_add);
      }
      elseif(isset($request->default_add))
      {
        $depot = Depot::where("num_depot",$request->default_add)->first();
      }
      $check_depot = StockDepot::where("stock_id",$stock->id)->where("depot_id",$depot->id)->exists();
      if($check_depot == true)
      {
        $depot->updated([
          "quantite"   => $depot->quantite + $qte_add,
          "entre"      => $depot->entre + $qte_add,
          "disponible" => $depot->disponible + $qte_add,
        ]);
        $stock_depot = StockDepot::where("stock_id",$stock->id)->where("depot_id",$depot->id)->first();
        $stock_depot->update([
          "quantite"   => $stock_depot->quantite + $qte_add,
          "entre"      => $stock_depot->entre + $qte_add,
          "disponible" => $stock_depot->disponible + $qte_add,
        ]);
        DepotSuivi::create([
          "stock_depot_id"=>$stock_depot->id,
          "quantite"=>$qte_add,
          "date_suivi"=>Carbon::today(),
          "operation"=>"augmenter",
        ]);
      }
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
    $qte_demi = $request->qte_demi;
    $stock   = Stock::find($id);

    $stock->update([
      "disponible"    => $stock->disponible - $qte_demi,
      "quantite"      => $stock->quantite - $qte_demi,
      "reste"         => $stock->reste - $qte_demi,
    ]);
    StockSuivi::create([
      "stock_id"       => $stock->id,
      "fonction"       => "démissionner",
      "quantite"       => request("qte_demi"),
      "date_suivi" => Carbon::today(),
    ]);
    $depot = null;

    if(isset($request->depot_add)){
      $depot = Depot::find($request->depot_add);
    }
    elseif(isset($request->default_add))
    {
      $depot = Depot::where("num_depot",$request->default_add)->first();
    }
    $check_depot = StockDepot::where("stock_id",$stock->id)->where("depot_id",$depot->id)->exists();
    if($check_depot == true)
    {
      $depot->updated([
        "quantite"   => $depot->quantite - $qte_demi,
        "entre"      => $depot->entre - $qte_demi,
        "disponible" => $depot->disponible - $qte_demi,
      ]);
      $stock_depot = StockDepot::where("stock_id",$stock->id)->where("depot_id",$depot->id)->first();
      $stock_depot->update([
        "quantite"   => $stock_depot->quantite - $qte_demi,
        "entre"      => $stock_depot->entre - $qte_demi,
        "disponible" => $stock_depot->disponible - $qte_demi,
      ]);
      DepotSuivi::create([
        "stock_depot_id"=>$stock_depot->id,
        "quantite"=>$qte_demi,
        "date_suivi"=>Carbon::today(),
        "operation"=>"augmenter",
      ]);
    }
    Session()->flash("success","Démessionner du stock effectuée");
    return back();
  }
}
