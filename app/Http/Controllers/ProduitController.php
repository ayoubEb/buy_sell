<?php

namespace App\Http\Controllers;

use App\Exports\ProduitExample;
use App\Exports\ProduitExport;
use App\Http\Requests\ProduitRequest;
use App\Imports\ProduitImport;
use App\Models\Categorie;
use App\Models\Produit;
use App\Models\Stock;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Maatwebsite\Excel\Facades\Excel;

class ProduitController extends Controller
{
  function __construct()
  {
    $this->middleware('permission:produit-list', ['only' => 'index']);

    $this->middleware('permission:produit-nouveau', ['only' => ['create','store']]);

    $this->middleware('permission:produit-modification', ['only' => ['edit','update']]);

    $this->middleware('permission:produit-suppression', ['only' => 'destroy']);

    $this->middleware('permission:produit-display', ['only' => 'show']);
  }
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
  */
  public function index()
  {
    $produits = Produit::select("id","reference","designation","prix_achat","prix_vente","prix_revient","quantite","statut","created_at")->get();
    $all      = [ 'produits'=>$produits ];
    return view('produits.index',$all);
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
  */
  public function create()
  {
    $categories = Categorie::select('id','nom')->get();
    $all        = [ "categories" => $categories ];
    return view("produits.create",$all);
  }

  /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
  */
  public function store(ProduitRequest $request)
  {
    $request->validated();
    if($request->hasFile("img")){
      $destination_path = 'public/images/produits/';
      $image_produit    = $request->file("img");
      $filename         = $image_produit->getClientOriginalName();
      $resu             = $filename;
      $request->file("img")->storeAs($destination_path,$filename);
    }

    $produit = Produit::create([
      "image"        => $resu ?? "",
      "reference"    => $request->reference,
      "categorie_id" => $request->categorie,
      "designation"  => Str::upper($request->designation),
      "description"  => $request->description,
      "prix_achat"   => $request->prix_achat,
      "prix_revient" => $request->prix_revient,
      "prix_vente"   => $request->prix_vente,
      "check_stock"=>1,
    ]);
    $count_stock = Stock::count();
    Stock::create([
      "produit_id"=>$produit->id,
      "num"=> "STO-00" . ($count_stock + 1),
      "date_stock"=>Carbon::today(),
    ]);

    Session()->flash("success","L'enregistrement du produit effectuée");
    return redirect()->route('produit.index');
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\Produit  $produit
   * @return \Illuminate\Http\Response
  */
  public function show(Produit $produit)
  {
    $stock         = $produit->stock;
    $suivi_actions = $produit->activities()->get();
    foreach($suivi_actions as $suivi_action){
      $check_user = User::where('id',$suivi_action->causer_id)->exists();
      if($check_user == true)
      {
        $suivi_action->user = User::where("id",$suivi_action->causer_id)->first()->name;
      }
      else
      {
        $suivi_action->user = null;
      }
    }
    $all = [
      "produit"       => $produit,
      "stock"         => $stock,
      "suivi_actions" => $suivi_actions
    ];
    return view("produits.show",$all);
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Models\Produit  $produit
   * @return \Illuminate\Http\Response
  */
  public function edit(Produit $produit)
  {
    $categories = DB::table("categories")->whereNull("deleted_at")->get();
    $all = [
        "produit"    => $produit,
        "categories" => $categories,
    ];
    return view("produits.edit",$all);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\Produit  $produit
   * @return \Illuminate\Http\Response
  */
  public function update(ProduitRequest $request, Produit $produit)
  {
    $request->validated();
    if (File::exists(storage_path().'/app/public/images/produits/'.$produit->image)) {
      File::delete(storage_path().'/app/public/images/produits/'.$produit->image);
    }

    if($request->hasFile("img"))
    {
      $destination_path_produit = 'public/images/produits';
      $image_produit            = $request->file("img");
      $img_produit              = $image_produit->getClientOriginalName();
      $request->file("img")->storeAs($destination_path_produit,$img_produit);
    }


    $produit->update([
      "image"        => $img_produit ?? $produit->image,
      "reference"    => $request->reference,
      "designation"  => Str::upper($request->designation),
      "description"  => $request->description,
      "categorie_id" => $request->categorie,
      "prix_revient" => $request->prix_revient,
      "prix_achat"   => $request->prix_achat,
      "prix_vente"   => $request->prix_vente,
      "statut"       => $request->statut == 1 ? 1 : 0,
    ]);

    Session()->flash("success","La modification du produit effectuée");
    return redirect()->route('produit.index');
  }
  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\Produit  $produit
   * @return \Illuminate\Http\Response
  */
  public function destroy(Produit $produit)
  {
    Stock::where("produt_id",$produit->id)->delete();
    $produit->delete();
    if (File::exists(storage_path().'/app/public/images/produits/'.$produit->image)) {
        File::delete(storage_path().'/app/public/images/produits/'.$produit->image);
    }
    Session()->flash("success","La suppression du produit effectuée");
    return back();
  }
  public function getProduit(Request $request){
    $produit = Produit::select("id","reference","prix_vente","designation")->where("id",$request->id)->first();
    $stock   = Stock::where("produit_id",$produit->id)->first();
    $all = [
      "produit" => $produit,
      "stock"   => $stock,
    ];
    return $all;
  }
  public function exporter(){
    return Excel::download(new ProduitExport, 'produits.xlsx');
  }
  public function example(){
    $data = [
      ['DésignationX' , "descriptionX" , "0" , "0" , "0","0"],
      ['DésignationY' , "descriptionY" , "0" , "0" , "0","0"],
      ['DésignationZ' , "descriptionZ" , "0" , "0" , "0","0"],
    ];
    // $produits = Produit::select("reference","designation","statut","check_depot","check_stock","description","prix_achat","prix_vente","prix_revient","created_at")->get();
    return Excel::download(new ProduitExample($data), 'example_produits.xlsx');
  }


  public function import( Request $request )
  {
    $import = new ProduitImport();
    Excel::import($import, $request->file);

    // Access rows from the import class
    $rows = $import->rows;
    foreach($rows as $row)
    {
      $count_stock = DB::table('stocks')->count() + 1;
      Stock::create([
        "produit_id"=>$row['pro_id'],
        "num"=>"STO-00" . $count_stock,
        "disponible"=>$row["qte"],
        "quantite"=>$row["qte"],
        "created_at"=>Carbon::today(),
        "updated_at"=>Carbon::today(),
      ]);
    }
    return back()->with("success","L'importation de file excel effectuée");
  }


  public function document()
  {
    $produits = Produit::select("categorie_id","reference","designation","statut","check_depot","check_stock","prix_achat","prix_vente","prix_revient","created_at")->get();
    $all      = [ "produits" => $produits ];
    $pdf      = Pdf::loadview('produits.document',$all);
    return $pdf->stream("produits");
  }
}
