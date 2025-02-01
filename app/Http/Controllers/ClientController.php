<?php

namespace App\Http\Controllers;

use App\Exports\ClientCsv;
use App\Exports\ClientXlsx;
use App\Models\Client;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

class ClientController extends Controller
{
  function __construct()
  {
    $this->middleware('permission:client-list|client-nouveau|client-modification|client-suppression', ['only' => ['index','show']]);

    $this->middleware('permission:client-nouveau', ['only' => ['create','store']]);

    $this->middleware('permission:client-modification', ['only' => ['edit','update']]);

    $this->middleware('permission:client-suppression', ['only' => ['destroy']]);
  }

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $clients = Client::all();
    $all = [ "clients" => $clients ];
    return view('clients.index',$all);
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
  */
  public function create()
  {
    return view('clients.create');
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
      "raison_sociale"  => ["required","not_regex:/^([a-z]+[0-9]+)|([A-Z]+[0-9]+)|([0-9]+)|([0-9]+[a-z]+)|([0-9]+[A-Z]+)$/"],
      "ville"           => ["required","not_regex:/^([a-z]+[0-9]+)|([A-Z]+[0-9]+)|([0-9]+)|([0-9]+[a-z]+)|([0-9]+[A-Z]+)$/"],
      "adresse"         => ["required"],
      "telephone"       => ["required","not_regex:/^([a-z]+)|([A-Z]+)|([A-Za-z]+)|([a-zA-Z]+)$/"],
      "ice"             => ["nullable", "digits_between:1,16","unique:clients,ice"],
      "if_client"       => ["nullable", "digits_between:1,16","unique:clients,if_client"],
      "rc"              => ["nullable", "digits_between:1,16","unique:clients,rc"],
      "email"           => ["nullable","unique:clients,email"],
    ]);
    $count_clients = DB::table("clients")->count();
    $iden = "cli-0".($count_clients + 1) . Str::random(6);
    $client = Client::create([
      "identifiant"     => $iden,
      "raison_sociale"  => $request->raison_sociale,
      "adresse"         => $request->adresse,
      "email"           => $request->email,
      "ville"           => $request->ville,
      "activite"        => $request->activite,
      "ice"             => $request->ice,
      "code_postal"     => $request->code_postal,
      "telephone"       => $request->telephone,
      "if_client"              => $request->if_client,
      "montant_devis"   => 0,
      "montant"         => 0,
      "payer"           => 0,
      "reste"           => 0,
      "rc"              => $request->rc,
      "moisCreation"    => date("m-Y"),
      "dateCreation"    => Carbon::now(),
    ]);

    return redirect()->route('client.index');
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\Client  $client
   * @return \Illuminate\Http\Response
   */
  public function show(Client $client)
  {
    $factures    = $client->factures()->where("status","validé")->get();
    $liste_devis = $client->factures()->where("status","en cours")->get();
    $all = [
      "client"    => $client,
      "factures"  => $factures,
      "liste_devis"  => $liste_devis,
    ];

    return view("clients.show",$all);
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Models\Client  $client
   * @return \Illuminate\Http\Response
  */
  public function edit(Client $client)
  {
    $all = [
      "client"  => $client,
    ];
      return view("clients.edit",$all);
  }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Client $client)
    {
      $request->validate([
        "raison_sociale"  => ["required","not_regex:/^([a-z]+[0-9]+)|([A-Z]+[0-9]+)|([0-9]+)|([0-9]+[a-z]+)|([0-9]+[A-Z]+)$/"],
        "ville"           => ["required","not_regex:/^([a-z]+[0-9]+)|([A-Z]+[0-9]+)|([0-9]+)|([0-9]+[a-z]+)|([0-9]+[A-Z]+)$/"],
        "adresse"         => ["required"],
        "telephone"           => ["required","not_regex:/^([a-z]+)|([A-Z]+)|([A-Za-z]+)|([a-zA-Z]+)$/"],
        'ice' => [
            "nullable", "digits_between:1,16",
            Rule::unique('clients', 'ice')->ignore($client->id),
        ],
        'if_client' => [
            "nullable", "digits_between:1,16",
            Rule::unique('clients', 'if_client')->ignore($client->id),
        ],
        'rc' => [
            "nullable", "digits_between:1,16",
            Rule::unique('clients', 'rc')->ignore($client->id),
        ],
        'email' => [
            "nullable","email",
            Rule::unique('clients', 'email')->ignore($client->id),
        ],
        "email"              => ["nullable"],

      ]);



      $client->update([
        "raison_sociale"  => $request->raison_sociale,
        "adresse"         => $request->adresse,
        "email"           => $request->email,
        "ville"           => $request->ville,
        "activite"        => $request->activite,
        "ice"             => $request->ice,
        "rc"              => $request->rc,
        "email"           => $request->email,
        "if_client"              => $request->if_client,
        "code_postal"     => $request->code_postal,
        "telephone"       => $request->telephone,
      ]);
      return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function destroy(Client $client,Request $request)
    {



            $client->delete();



        return back();



    }



    public function exportXlsx(){
      return Excel::download(new ClientXlsx, 'clients.xlsx');
    }

    public function exportCsv(){
      return Excel::download(new ClientCsv, 'clients.csv');
    }

    public function document()
    {
      $clients = Client::select("identifiant","raison_sociale","adresse","ville","code_postal","ice","rc" , "if_client" , "telephone" , "email" , "montant" , "payer" , "reste" ,"montant_devis","created_at")->get();
      $all      = [ "clients" => $clients ];
      $pdf      = Pdf::loadview('clients.document',$all);
      return $pdf->stream("clients");
    }

}
