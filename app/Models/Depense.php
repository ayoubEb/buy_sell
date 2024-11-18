<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Depense extends Model
{
    use HasFactory , SoftDeletes;
  protected $table = "depenses";
  protected $guarded = [];
  /**
   * Get the categorie that owns the Depense
   *
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function categorie(): BelongsTo
  {
      return $this->belongsTo(CategorieDepense::class, 'categorie_depense_id', 'id');
  }
}
