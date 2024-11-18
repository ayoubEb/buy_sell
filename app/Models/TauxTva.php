<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class TauxTva extends Model
{
  use HasFactory,SoftDeletes,LogsActivity;
  protected $table = "taux_tvas";
  protected $guarded = [];
  public function getActivitylogOptions(): LogOptions
  {
      return LogOptions::defaults()
          ->uselogName('taux_tva')
          ->logAll()
          ->setDescriptionForEvent(fn(string $eventName) => "{$eventName}");
  }
}
