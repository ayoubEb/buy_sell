<?php

namespace App\Http\Controllers;

use App\Models\Produit;
use App\Models\Stock;
use App\Models\StockSuivi;
use Carbon\Carbon;
use Illuminate\Http\Request;

class StockController extends Controller
{
  function __construct()
  {
    $this->middleware('permission:stock-list|stock-nouveau|stock-modification', ['only' => ['index','show']]);

    $this->middleware('permission:stock-nouveau', ['only' => ['new','store']]);

    $this->middleware('permission:stock-modification', ['only' => ['edit','update']]);

    $this->middleware('permission:stock-display', ['only' => ['show']]);
  }
    /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $produits           = Produit::select("id","reference","designation","quantite")->paginate(10);
    $produits_reference = Produit::select("reference")->get();
    $all = [
      "produits"   => $produits,
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
    $all = [ "produit" => $produit ];
    return view("stocks.new" , $all);
  }



  /**<
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    $request->validate([
      "reference"  => ['required','exists:produits,reference'],
      "quantite" => ['required','numeric','min:1'],
      "qte_min"  => ['required','numeric','min:1'],
      "initial"  => ['required','numeric','min:1'],
    ]);

    $count_stock     = Stock::count();
    $produit         = Produit::where("reference",$request->reference)->first();
    $stock = Stock::create([
      "num"        => "STOCK-00" . $count_stock + 1,
      "produit_id" => $produit->id,
      "initial"    => $request->initial,
      "date_stock" => Carbon::now(),
      "min"        => $request->qte_min,
      "disponible"=>$request->quantite,
    ]);
    $produit->update([
      "quantite"=>$request->quantite,
      "qte_augmenter"=>$request->quantite,
    ]);
    $stock->history()->create([
      "stock_id"       => $stock->id,
      "fonction"       => "nouveau",
      "quantite"       => $request->quantite,
      "date_mouvement" => Carbon::today(),
    ]);

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
    $stockHistoriques = $stock->history()->get();
    $all = [
      "stock"            => $stock,
      "stockHistoriques" => $stockHistoriques,
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
    public function update(Request $request, Stock $stock)
    {
      $request->validate([
        "reference"  => ['required','exists:stocks,num'],
        "qte_min"  => ['required','numeric','min:1'],
        "qte_max"  => ['required','numeric','min:1'],
        "initial"  => ['required','numeric','min:1'],
      ]);

      $stock->update([
        "initial"    => $request->initial,
        "min"        => $request->qte_min,
        "max"        => $request->qte_max,
      ]);
      Session()->flash("success","La modification du stock effectuée");
        return redirect()->route('stock.index');
    }
}
