<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vente extends Model
{
  use HasFactory , SoftDeletes;
  protected $table='ventes';
  protected $guarded = [];

  /**
   * Get the facture that owns the FactureProduit
   *
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function facture(): BelongsTo
  {
      return $this->belongsTo(LigneVente::class, 'ligne_vente_id');
  }
  /**
   * Get the produit that owns the FactureProduit
   *
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function produit(): BelongsTo
  {
      return $this->belongsTo(Produit::class, 'produit_id');
  }

}
