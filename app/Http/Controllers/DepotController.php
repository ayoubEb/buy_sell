<?php

namespace App\Http\Controllers;

use App\Exports\DepotCsv;
use App\Exports\DepotExample;
use App\Exports\DepotXlsx;
use App\Models\Depot;
use App\Models\Produit;
use App\Models\StockDepot;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;
class DepotController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
  */
  function __construct()
  {

    $this->middleware('permission:depot-list', ['only' => 'index']);

    $this->middleware('permission:depot-nouveau', ['only' => ['create','store']]);

    $this->middleware('permission:depot-modification', ['only' => ['edit','update','active' , 'inactive']]);

    $this->middleware('permission:depot-suppression', ['only' => 'destroy']);

    $this->middleware('permission:depot-display', ['only' => 'show']);
  }
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
  */
  public function index()
  {
    $depots = Depot::select("id","num_depot","quantite","disponible","sortie","entre","adresse","statut")->get();
    $all    = [ "depots" => $depots ];
    return view("depots.index",$all);
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
  */
  public function create()
  {
    return view("depots.create");
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
      "adresse"   => ["required"],
      "num_depot" => ['required','unique:depots,num_depot']
    ]);
    Depot::create([
      "num_depot" => $request->num_depot,
      "adresse"   => $request->adresse
    ]);
    return redirect()->route('depot.index')->with("success","L'enregistrement de depôt effectuée");
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\Depot  $depot
   * @return \Illuminate\Http\Response
  */
  public function show(Depot $depot)
  {
    $suivi_actions = $depot->activities()->get();
    foreach($suivi_actions as $suivi_action){
      $user = User::find($suivi_action->causer_id);
      $suivi_action->user = $user ? $user->name : null; // Handle case where user might not be found;
    }

    $stock_depots = $depot->stocks()->get();
    foreach($stock_depots as $stock_depot)
    {
      $stock_depot->produit = Produit::find($stock_depot->produit_id);
    }
    $all = [
      "depot"         => $depot,
      "suivi_actions" => $suivi_actions,
      "stock_depots"  => $stock_depots
    ];
    return view("depots.show",$all);
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Models\Depot  $depot
   * @return \Illuminate\Http\Response
  */
  public function edit(Depot $depot)
  {
    $all = [ "depot" => $depot ];
    return view("depots.edit",$all);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\Depot  $depot
   * @return \Illuminate\Http\Response
  */
  public function update(Request $request, Depot $depot)
  {
    $request->validate([
      "adresse"   => ["required"],
      'num_depot' => [
        "required",
        Rule::unique('depots', 'num_depot')->ignore($depot->id),
      ],
    ]);
    $depot->update([
      "adresse"   => $request->adresse,
      "num_depot" => $request->num_depot,
    ]);
    return redirect()->route('depot.index')->with("success","La modification de depôt effectuée");
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\Depot  $depot
   * @return \Illuminate\Http\Response
  */
  public function inactive($id)
  {

    $depot = Depot::find($id);
    $stockDepots = StockDepot::where("depot_id",$id)->get();
    foreach($stockDepots as $stockDepot)
    {
      $stockDepot->update([
        "inactive"=>$stockDepot->disponible,
        "disponible"=>0,
      ]);
    }
    $depot->update(["statut" => 0]);
    return redirect()->route('depot.index')->with("success","La modification de depôt effectuée");
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\Depot  $depot
   * @return \Illuminate\Http\Response
  */
  public function active($id)
  {
    $depot = Depot::find($id);
    $stockDepots = StockDepot::where("depot_id",$id)->get();
    foreach($stockDepots as $stockDepot)
    {
      $stockDepot->update([
        "disponible"=>$stockDepot->inactive,
        "inactive"=>0,
      ]);

    }
    $depot->update(["statut" => 1]);
    return redirect()->route('depot.index')->with("success","La modification de depôt effectuée");
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\Depot  $depot
   * @return \Illuminate\Http\Response
  */
  public function destroy(Depot $depot)
  {
    $depot->delete();
    return back()->with("success","La suppression de depôt effectuée");
  }


  public function exportXlsx(){
    return Excel::download(new DepotXlsx, 'depôts.xlsx');
  }
  public function exportCsv(){
    return Excel::download(new DepotCsv, 'depôts.csv');
  }

  public function example(){
    $data = [
      ['num_x', 'adresse_x'],
      ['num_y', 'adresse_y'],
    ];
    return Excel::download(new DepotExample($data), 'depot_example.xlsx');
  }

  public function document()
  {
    $depots = Depot::select("num_depot","adresse","quantite","disponible","entre","statut","sortie","created_at")->get();
    $all        = [ "depots" => $depots ];
    $pdf = Pdf::loadview('depots.document',$all);
    return $pdf->stream("depots");
  }
}
