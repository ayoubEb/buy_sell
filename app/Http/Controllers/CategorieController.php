<?php

namespace App\Http\Controllers;

use App\Exports\CategorieCsv;
use App\Exports\CategorieExample;
use App\Exports\Categories\ExportCsv;
use App\Exports\CategorieXlsx;
use App\Http\Requests\CategorieRequest;
use App\Imports\CategorieImport;
use App\Models\Categorie;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Maatwebsite\Excel\Facades\Excel;

class CategorieController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
  */
  function __construct()
  {

    $this->middleware('permission:categorie-list', ['only' => 'index']);

    $this->middleware('permission:categorie-nouveau', ['only' => ['create','store']]);

    $this->middleware('permission:categorie-modification', ['only' => ['edit','update']]);

    $this->middleware('permission:categorie-suppression', ['only' => 'destroy']);

    $this->middleware('permission:categorie-display', ['only' => 'show']);
  }
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
  */
  public function index()
  {
    $categories = Categorie::select("id","nom","created_at")->get();
    $all        = [ "categories" => $categories ];
    return view('categories.index',$all);
  }

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
  */
  public function archives()
  {
    $categories = Categorie::select("id","nom","created_at")->get();
    $all        = [ "categories" => $categories ];
    return view('categories.index',$all);
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    return view("categories.create");
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
  */
  public function store(CategorieRequest $request)
  {
    // $this->setEnvValue('DB_DATABASE', 'buy_sell');
    // DB::purge('mysql');
    // DB::reconnect('mysql');
    // $this->setEnvValue('APP_NAME', 'buySell');
    // Artisan::call('config:clear');
    // Artisan::call('config:cache');
    // return view("auth.login");

    //     $servername = "localhost";
    // $username = "root";
    // $password = "";

    // // Create connection
    // $conn = new mysqli($servername, $username, $password);
    // // Check connection
    // if ($conn->connect_error) {
    //   die("Connection failed: " . $conn->connect_error);
    // }

    // // Create database
    // $d = "my";
    // $sql = "CREATE DATABASE " . $d;
    // if ($conn->query($sql) === TRUE) {
    //   echo "Database created successfully";
    // } else {
    //   echo "Error creating database: " . $conn->error;
    // }

    // $conn->close();

        // $defaultCongig = config('database.connections.mysql')
    // DB::reconnect('tst');
    // dd($my_config);
    // Set the default connection

    $request->validate();

    if($request->hasFile("img")){
      $destination_path = 'public/images/category/';
      $image_produit    = $request->file("img");
      $filename         = $image_produit->getClientOriginalName();
      $img_ex           = DB::table("categories")->where("image",$filename)->exists();
      $c                = DB::table("categories")->where("image",$filename)->count();
      $resu             = $filename;
      if($img_ex == true)
      {
        $resu = ($c + 1). '-' . $filename;
        $request->file("img")->storeAs($destination_path,$filename .'( ' . $c + 1 . ')');
      }
      else
      {
        $resu = $filename;
        $request->file("img")->storeAs($destination_path,$filename);

      }
    }
    Categorie::create([
      "nom"         => $request->nom,
      "description" => $request->description,
      "image"=>$resu ?? '',
    ]);


    Session()->flash("success","L'enregistrement du catégorie effectuée");
    return redirect()->route('categorie.index');
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\Categorie  $produit
   * @return \Illuminate\Http\Response
  */
  public function show(Categorie $categorie)
  {
    $suivi_actions = $categorie->activities()->get();
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
      "categorie"     => $categorie,
      "suivi_actions" => $suivi_actions
    ];
    return view("categories.show",$all);
  }
  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Models\Categorie  $categorie
   * @return \Illuminate\Http\Response
  */
  public function edit(Categorie $categorie)
  {
    $all = [ 'categorie' => $categorie ];
    return view("categories.edit",$all);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\Categorie  $categorie
   * @return \Illuminate\Http\Response
  */
  public function update(Request $request, CategorieRequest $categorie)
  {
    $request->validate();

      File::delete(storage_path().'/app/public/images/category/'.$categorie->image);

      if($request->hasFile("img")){
        $destination_path = 'public/images/category/';
        $image_produit = $request->file("img");
        $filename =  $image_produit->getClientOriginalName();
        $request->file("img")->storeAs($destination_path,$filename);
      }
      $categorie->update([
        "image"=>$filename ?? $categorie->image,
          "nom"         => $request->nom == $categorie->nom ? $categorie->nom : $request->nom,
          "description" => $request->description,
      ]);
      Session()->flash("update","La modification du catégorie effectuée");
      return redirect()->route('categorie.index');
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\Categorie  $categorie
   * @return \Illuminate\Http\Response
  */
  public function destroy(Categorie $categorie)
  {
    $categorie->delete();
    if (File::exists(storage_path().'/app/public/images/category/'.$categorie->image)) {
      File::delete(storage_path().'/app/public/images/category/'.$categorie->image);
    }
    Session()->flash("success","La suppression du catégorie effectuée");
    return back();
  }


  public function exportCsv(){
    return Excel::download(new CategorieCsv, 'categories.csv');
  }
  public function exportXlsx(){
    return Excel::download(new CategorieXlsx, 'categories.xlsx');
  }

  public function example(){
    $data = [
      ['nom_1', 'description_1'],
      ['nom_2', 'description_2'],
      ['nom_3', 'description_3'],
    ];
    return Excel::download(new CategorieExample($data), 'categories.xlsx');
  }


  public function document()
  {
    $categories = Categorie::select("image","nom","description","created_at")->get();
    $all        = [ "categories" => $categories ];
    $pdf = Pdf::loadview('categories.document',$all);
    return $pdf->stream("catégories");
  }

  public function import( Request $request )
  {

    Excel::import(new CategorieImport, $request->file);
    return back();
  }




}