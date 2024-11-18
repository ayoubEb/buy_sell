<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class VentePaiement extends Model
{
  use HasFactory , SoftDeletes , LogsActivity;
  protected $table = "vente_paiements";
  protected $guarded = [];
  /**
   * Get the user that owns the FacturePaiement
   *
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function facture(): BelongsTo
  {
      return $this->belongsTo(LigneVente::class, 'ligne_vente_id');
  }
  /**
   * Get the user that owns the FacturePaiement
   *
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function client(): BelongsTo
  {
      return $this->belongsTo(Client::class, 'client_id');
  }




  public function getActivitylogOptions(): LogOptions
  {
    return LogOptions::defaults()
      ->useLogName('vente_paiement')
      ->logOnly(["numero_operation",'date_paiement','num','type_paiement','status',"payer","date_paiement"])
      ->setDescriptionForEvent(fn(string $eventName) => "{$eventName}");
  }
}
