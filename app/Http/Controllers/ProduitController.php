<?php

namespace App\Http\Controllers;

use App\Models\MarqueProduit;
use App\Models\Produit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\Rule;

class ProduitController extends Controller
{
    function __construct()
    {
      $this->middleware('permission:produit-list|produit-nouveau|produit-modification|produit-suppression', ['only' => ['index','show']]);

      $this->middleware('permission:produit-nouveau', ['only' => ['create','store']]);

      $this->middleware('permission:produit-modification', ['only' => ['edit','update']]);

      $this->middleware('permission:produit-suppression', ['only' => ['destroy']]);

      $this->middleware('permission:produit-display', ['only' => ['show']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $produits = Produit::all();
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
        $categories = DB::table("categories")->select('id','nom')->whereNull("deleted_at")->get();
        $marques    = DB::table("marques")->select("id","nom")->get();
        $all = [
            "categories" => $categories,
            "marques"    => $marques,
        ];
        return view("produits.create",$all);
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
            "reference"    => ["required","unique:produits,reference"],
            "marque"    => ["required","exists:marques,id"],
            "designation"  => ["required"],
            "categorie"    => ["required"],
            "prix_achat"   => ["required","min:0","numeric"],
            "prix_revient"   => ["required","min:0","numeric"],
            "prix_vente"   => ["required","min:0","numeric"],

          ]);

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
            "categorie_id"    => $request->categorie,
            "marque_id"    => $request->marque,
            "designation"  => Str::upper($request->designation),
            "description"  => $request->description,
            "prix_achat"   => $request->prix_achat,
            "prix_revient" => $request->prix_revient,
            "prix_vente" => $request->prix_vente,
            "quantite"     => 0,
          ]);
          Session()->flash("success","Lca modification du produit effectuée");
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
      $all = [ "produit" => $produit ];
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
        $categories       = DB::table("categories")->whereNull("deleted_at")->get();
        $marques    = DB::table("marques")->select("id","nom")->get();

        $all = [
            "produit"          => $produit,
            "categories"       => $categories,
            "marques"       => $marques,
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
    public function update(Request $request, Produit $produit)
    {
        $request->validate([
            "reference"   => ["required",Rule::unique('produits', 'reference')->ignore($produit->id),],
            "designation" => ["required"],
            "categorie" => ["required",'exists:categories,id'],
            "prix_achat"   => ["required","min:0","numeric"],
            "prix_revient"   => ["required","min:0","numeric"],
            "prix_vente"   => ["required","min:0","numeric"],
          ]);

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
              "categorie_id"  => $request->categorie,
              "marque_id"  => $request->marque,
              "prix_revient" => $request->prix_revient,
              "prix_achat" => $request->prix_achat,
              "prix_vente" => $request->prix_vente,
            ]);

        Session()->flash("update","La modification du produit effectuée");
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
        $produit->delete();
        if (File::exists(storage_path().'/app/public/images/produits/'.$produit->image)) {
            File::delete(storage_path().'/app/public/images/produits/'.$produit->image);
        }
        Session()->flash("update","La suppression du produit effectuée");
        return back();
    }
}
