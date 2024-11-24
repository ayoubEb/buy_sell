<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Caisse extends Model
{
  use HasFactory , SoftDeletes;
  protected $table = "caisses";
  protected $guarded = [];
  /**
   * Get the categorie that owns the Depense
   *
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function categorie(): BelongsTo
  {
      return $this->belongsTo(CategorieCaisse::class, 'categorie_caisse_id', 'id');
  }
}
