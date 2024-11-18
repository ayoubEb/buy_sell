<?php

namespace App\Http\Controllers;

use App\Models\LigneAchat;
use Illuminate\Http\Request;

class LigneRapportController extends Controller
{
    public function index(){
      $ligneRapports = LigneAchat::groupBy("mois")->select("mois")->get();
      foreach($ligneRapports as $rapport){
        $rapport->sum = LigneAchat::where("mois",$rapport->mois)->sum("ttc");
        $rapport->count = LigneAchat::where("mois",$rapport->mois)->count();
      }
      $all = [
        "ligneRapports" => $ligneRapports
      ];
      return view("ligneRapports.index",$all);
    }

    public function show($mois = null){
      $achats = LigneAchat::where("mois",$mois)->get();
      $all = [ "achats" => $achats ];
      return view("ligneRapports.show",$all);
    }
}
