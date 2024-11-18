<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Client extends Model
{
  use HasFactory,SoftDeletes , LogsActivity;
  protected $table="clients";
  protected $guarded = [];
  public function getActivitylogOptions(): LogOptions
  {
    return LogOptions::defaults()
      ->useLogName('client')
      ->logOnly(["identifiant","raison_sociale","adresse","email","ville","ice","if_client","rc","telephone","code_postal","activite","montant","payer","reste","solde"])
      ->setDescriptionForEvent(fn(string $eventName) => "{$eventName}");
  }
}
