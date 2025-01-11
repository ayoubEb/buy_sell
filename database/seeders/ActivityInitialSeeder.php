<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Activitylog\Models\Activity;

class ActivityInitialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $activites =Activity::select("id","causer_id","causer_type")->get();
      foreach($activites as $activite)
      {
        $activite->update([
          "causer_id"=>1,
          "causer_type"=>"App\Models\User",
        ]);
      }
    }
}
