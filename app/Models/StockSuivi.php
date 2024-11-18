<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class StockSuivi extends Model
{
  use HasFactory;
  protected $table = "stock_suivis";
  protected $guarded = [];
  use SoftDeletes,LogsActivity;
  public function getActivitylogOptions(): LogOptions
  {
      return LogOptions::defaults()
          ->uselogName('stockSuivi')
          ->logAll()
          ->setDescriptionForEvent(fn(string $eventName) => "{$eventName}");
  }
  /**
   * Get the stock that owns the StockHistorique
   *
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
  */
  public function stock(): BelongsTo
  {
      return $this->belongsTo(Stock::class, 'stock_id');
  }
}
