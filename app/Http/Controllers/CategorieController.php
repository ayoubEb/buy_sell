<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;

class CategorieController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
    */

    function __construct()
    {

        $this->middleware('permission:categorie-list|categorie-nouveau|categorie-modification|categorie-suppression', ['only' => ['index','show']]);

        $this->middleware('permission:categorie-nouveau', ['only' => ['create','store']]);

        $this->middleware('permission:categorie-modification', ['only' => ['edit','update']]);

        $this->middleware('permission:categorie-suppression', ['only' => ['destroy']]);
    }
      /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $categories = Categorie::all();
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
  public function store(Request $request)
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

    $request->validate([
      "nom" => ["required","unique:categories,nom"],
      "img"=>["nullable","unique:categories,image"],
    ]);

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
  public function update(Request $request, Categorie $categorie)
  {
    $request->validate([
      'nom' => [
        "required",
        Rule::unique('categories', 'nom')->ignore($categorie->id),
      ],
    ]);

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


  function setEnvValue($key, $value)
  {
      $path = base_path('.env');

      if (file_exists($path)) {
          $content = file_get_contents($path);

          // Replace existing key-value pair or add a new one
          if (strpos($content, "{$key}=") !== false) {
              $content = preg_replace("/^{$key}=.*/m", "{$key}={$value}", $content);
          } else {
              $content .= "\n{$key}={$value}";
          }

          file_put_contents($path, $content);

          // Clear config cache to apply changes


      }
  }



  public function document(){
    $categories = Categorie::all();
    $data = [
      "categories" => $categories
    ];
    $pdf = Pdf::loadView('categories.document', $data);
    return $pdf->stream();
  }
}
