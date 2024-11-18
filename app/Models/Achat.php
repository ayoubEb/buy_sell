<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Achat extends Model
{
  protected $table = "achats";
  protected $guarded = [];
  use HasFactory,SoftDeletes;
  /**
   * Get the produit that owns the Achat
   *
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function produit(): BelongsTo
  {
      return $this->belongsTo(Produit::class, 'produit_id');
  }
  /**
   * Get the produit that owns the Achat
   *
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function ligneAchat(): BelongsTo
  {
      return $this->belongsTo(LigneAchat::class, 'ligne_achat_id');
  }
}
