<?php

namespace App\Http\Controllers;

use App\Models\Comptoir;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Spatie\Activitylog\Models\Activity;

class ComptoirController extends Controller
{
   /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
  */
  function __construct()
  {

    $this->middleware('permission:comptoir-list', ['only' => 'index']);

    $this->middleware('permission:comptoir-nouveau', ['only' => ['create','store']]);

    $this->middleware('permission:comptoir-modification', ['only' => ['edit','update']]);

    $this->middleware('permission:comptoir-suppression', ['only' => 'destroy']);

    $this->middleware('permission:comptoir-display', ['only' => 'show']);
  }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $comptoirs = Comptoir::select("id","num")->get();
      $all = [
        "comptoirs" => $comptoirs
      ];
      return view("comptoirs.index",$all);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      return view("comptoirs.create");
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
          "num"=>["required",'unique:comptoirs,num']
        ]);
        Comptoir::create([
          "num"    => $request->num,
          "statut" => $request->statut == 1 ? 1 : 0,
        ]);
        return redirect()->route('comptoir.index')->with("success","L'enregistrement de comptoir effectuée");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Comptoir  $comptoir
     * @return \Illuminate\Http\Response
     */
    public function show(Comptoir $comptoir)
    {
      $suivi_actions = $comptoir->activities()->get();
      foreach($suivi_actions as $suivi_action){
        $user = User::find($suivi_action->causer_id);
        $suivi_action->user = $user ? $user->name : null; // Handle case where user might not be found;
      }
      $all = [
        "comptoir"     => $comptoir,
        "suivi_actions" => $suivi_actions
      ];
      return view("comptoirs.show",$all);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Comptoir  $comptoir
     * @return \Illuminate\Http\Response
     */
    public function edit(Comptoir $comptoir)
    {
      $all = [ "comptoir" => $comptoir ];
      return view("comptoirs.edit",$all);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Comptoir  $comptoir
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Comptoir $comptoir)
    {
      $request->validate([
        'num' => [
          "required",
          Rule::unique('comptoirs', 'num')->ignore($comptoir->id),
        ],
      ]);
      $comptoir->update([
        "num"    => $request->num,
        "statut" => $request->statut == 1 ? 1 : 0,
      ]);
      return redirect()->route('comptoir.index')->with("success","La modification de comptoir effectuée");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Comptoir  $comptoir
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comptoir $comptoir)
    {
      $comptoir->delete();
      return back()->with("success","La suppression de comptoir effectuée");
    }
}
