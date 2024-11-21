<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class AchatPaiement extends Model
{
  protected $table = "achat_paiements";
  protected $guarded = [];
  use SoftDeletes;
  use HasFactory;



  /**
   * Get the founrnisseur that owns the AchatPaiement
   *
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function fournisseur(): BelongsTo
  {
      return $this->belongsTo(Fournisseur::class, 'fournisseur_id');
  }
  /**
   * Get the founrnisseur that owns the AchatPaiement
   *
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function ligne(): BelongsTo
  {
      return $this->belongsTo(LigneAchat::class, 'ligne_achat_id');
  }

  /**
   * Get the cheque associated with the AchatPaiement
   *
   * @return \Illuminate\Database\Eloquent\Relations\HasOne
   */
  public function cheque(): HasOne
  {
      return $this->hasOne(AchatCheque::class, 'achat_paiement_id', 'id');
  }
}
