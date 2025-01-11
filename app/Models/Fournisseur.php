<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Fournisseur extends Model
{
    use HasFactory,LogsActivity , SoftDeletes;
    protected $table = "fournisseurs";
    protected $guarded = [];
    public function getActivitylogOptions(): LogOptions
    {
      return LogOptions::defaults()
      ->uselogName('fournisseur')
      ->logOnly(["identifiant" , "raison_sociale" , "adresse" , "ville" , "rc" , "ice" , "code_postal" , "telephone" , "fix" , "pays" , "email" , "montant" , "payer" , "reste" , "montant_demande"])
      ->setDescriptionForEvent(fn(string $eventName) => "{$eventName}");
    }

    /**
     * Get all of the ligne_achats for the Fournisseur
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
    */
    public function ligne_achats(): HasMany
    {
        return $this->hasMany(LigneAchat::class, 'fournisseur_id', 'id');
    }
}
