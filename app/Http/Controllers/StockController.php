<?php

namespace App\Http\Controllers;

use App\Exports\StockCsv;
use App\Exports\StockXlsx;
use App\Http\Requests\StockRequest;
use App\Models\Depot;
use App\Models\DepotSuivi;
use App\Models\Produit;
use App\Models\Stock;
use App\Models\StockDepot;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\Activitylog\Models\Activity;
class StockController extends Controller
{
  function __construct()
  {
    $this->middleware('permission:stock-list', ['only' => 'index']);

    $this->middleware('permission:stock-nouveau', ['only' => ['new','store']]);

    $this->middleware('permission:stock-modification', ['only' => ['edit','update']]);

    $this->middleware('permission:stock-display', ['only' => 'show']);
  }
  /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
  */
  public function index()
  {
    $produits           = Produit::select("id","reference","designation","quantite","check_stock")->paginate(10);
    foreach($produits as $produit){
      if($produit->check_stock == 1)
      {
        $stock = Stock::where("produit_id",$produit->id)->first();
        $produit->disponible = Stock::where("produit_id",$produit->id)->first()->disponible;
        $produit->depots           = $stock->depots()->get();
        $produit->check_default    = StockDepot::where("stock_id",$stock->id)->where("check_default",1)->exists();
        $depot_default = null;
        if($produit->check_default == true)
        {
          $depot_id = StockDepot::where("stock_id",$stock->id)->where("check_default",1)->first()->depot_id;
          $produit->depot_default = Depot::find($depot_id);
        }
      else{
        $produit->disponible = 0;
      }

      }
    }
    $produits_reference = Produit::select("reference")->get();
    $all = [
      "produits"   => $produits,
      "depot_default"=>$depot_default ?? [],
      "references" => $produits_reference,
    ];

    return view("stocks.index",$all);
  }

  /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
  */
  public function new($id)
  {
    $produit = Produit::find($id);
    $depots = Depot::select("id","num_depot","adresse")->where("statut",1)->get();
    if($produit->check_stock == 0)
    {
      $all = [
        "produit" => $produit,
        "depots"=>$depots
      ];
      return view("stocks.new" , $all);
    }
    else
    {
      Session("warning","Le produit a été déja exists le stock");
      return back();
    }

  }



  /**<
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
  */
  public function store(StockRequest $request)
  {
    $request->validated();
    $count_stock     = Stock::count();
    $produit         = Produit::where("reference",$request->reference_pro)->first();

    $stock = Stock::create([
      "num"        => "STOCK-00" . $count_stock + 1,
      "produit_id" => $produit->id,
      "initial"    => $request->initial ?? 0,
      "qte_alert"  => $request->qte_alert,
      "date_stock" => Carbon::now(),
      "min"        => $request->qte_min,

    ]);
    $produit->update([
      "quantite"      => $request->quantite,
    ]);

    $sum_qte = 0;


      foreach($request->depot as $key => $val)
      {
        $qte      = $request->qte[$key];
        $sum_qte += $qte;
        $depot    = Depot::find($val);
        $depot->update([
          "quantite"   => $depot->quantite + $qte,
          "disponible" => $depot->disponible + $qte,
          "entre"      => $depot->entre + $qte,
        ]);
       $stock_depot = StockDepot::create([
          "stock_id"   => $stock->id,
          "depot_id"   => $depot->id,
          "quantite"   => $qte,
          "entre"      => $qte,
          "disponible" => $qte,
        ]);

        DepotSuivi::create([
          "stock_depot_id" => $stock_depot->id,
          "date_suivi"      => Carbon::today(),
          "quantite"       => $qte,
          "operation"      => "initial",
        ]);
      }
      $stock->update([
        "qte_augmenter"=>$sum_qte,
        "disponible"=>$sum_qte,
        "reste"=>$sum_qte,
      ]);


      $stock->suivis()->create([
        "stock_id"       => $stock->id,
        "fonction"       => "initial",
        "quantite"       => $qte,
        "date_suivi" => Carbon::today(),
      ]);


      if(isset($request->depot_default))
      {
        $depot_default = Depot::select("num_depot","id")->where("num_depot",$request->depot_default)->first();
        StockDepot::where("depot_id",$depot_default->id)->where("stock_id",$stock->id)->update([
          "check_default"=>1
        ]);
      }



    Session()->flash("success","L'enregistrement du stock effectuée");
    return redirect()->route('stock.index');
  }

  /**
    * Display the specified resource.
    *
    * @param  \App\Models\Stock  $stock
    * @return \Illuminate\Http\Response
  */
  public function show(Stock $stock)
  {
    $stockSuivis   = $stock->suivis()->get();
    $depots        = $stock->depots()->get();
    $count_depots  = Depot::count();
    $check_default = StockDepot::where("stock_id",$stock->id)->where("check_default",1)->exists();
    $depot_default = null;
    if($check_default == true)
    {
      $depot_id = $stock->depots()->where("check_default",1)->first()->depot_id;
      $depot_default = Depot::find($depot_id);
    }
    $suivi_actions = Activity::where("log_name","stock")->where("subject_id",$stock->id)->get();
    foreach($suivi_actions as $suivi_action){
      $check_user = User::where('id',$suivi_action->causer_id)->exists();
      if($check_user == true)
      {
        $suivi_action->user = User::find($suivi_action->causer_id)->first()->name;
      }
      else
      {
        $suivi_action->user = null;
      }
    }
    $all = [
      "stock"         => $stock,
      "depots"        => $depots,
      "suivi_actions" => $suivi_actions,
      "stockSuivis"   => $stockSuivis,
      "depot_default" => $depot_default,
      "check_default" => $check_default,
      "count_depots"  => $count_depots,
    ];
    return view("stocks.show",$all);
  }

  /**
    * Show the form for editing the specified resource.
    *
    * @param  \App\Models\Stock  $stock
    * @return \Illuminate\Http\Response
  */
  public function edit(Stock $stock)
  {
    $all = [ "stock" => $stock ];
    return view("stocks.edit",$all);
  }

  /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  \App\Models\Stock  $stock
    * @return \Illuminate\Http\Response
  */
  public function update(StockRequest $request, Stock $stock)
  {
    // $request->validate([
    //   "reference" => ['required','exists:stocks,num'],
    //   "qte_min"   => ['required','numeric','min:1'],
    //   "qte_max"   => ['required','numeric','min:0'],
    //   "qte_alert" => ['required','numeric','min:1'],
    // ]);
    $request->validated();
    $stock->update([
      'num'=>$request->reference,
      "initial"   => $request->initial,
      "qte_alert" => $request->qte_alert,
      "min"       => $request->qte_min,
      "max"       => $request->qte_max,
    ]);
    Session()->flash("success","La modification du stock effectuée");
    return redirect()->route('stock.index');
  }



  public function exportXlsx(){
    return Excel::download(new StockXlsx, 'stocks.xlsx');
  }
  public function exportCsv(){
    return Excel::download(new StockCsv, 'stocks.csv');
  }



  public function document()
  {
    $stocks = Stock::select("produit_id","num","quantite","disponible","reste","min","max","date_stock","sortie","qte_alert","qte_achat","qte_vente","qte_augmenter","qte_achatRes","qte_venteRes")->get();
    $all      = [ "stocks" => $stocks ];
    $pdf      = Pdf::loadview('stocks.document',$all);
    // $pdf->setPaper('a4', 'landscape');
    $pdf->render();
    return $pdf->stream("stocks");
  }

}
