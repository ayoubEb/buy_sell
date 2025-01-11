<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class LigneVente extends Model
{
  use HasFactory;
  protected $table='ligne_ventes';
  protected $guarded = [];
  use SoftDeletes;

  public function client(){
    return $this->belongsTo(Client::class, 'client_id')->withTrashed();
  }


  /**
   * Get all of the prdduits for the LigneVente
   *
   * @return \Illuminate\Database\Eloquent\Relations\HasMany
   */
  public function produits(): HasMany
  {
      return $this->hasMany(Vente::class, 'ligne_vente_id', 'id');
  }

  /**
   * Get the entreprise that owns the Facture
   *
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function entreprise(): BelongsTo
  {
      return $this->belongsTo(Entreprise::class, 'entreprise_id');
  }

}
