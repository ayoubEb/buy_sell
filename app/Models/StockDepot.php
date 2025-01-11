<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class StockDepot extends Model
{
    use HasFactory;
    use HasFactory ,LogsActivity;
    protected $table = "stock_depots";
    protected $guarded = [];
    /**
     * Get the stock that owns the StockDepot
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function stock(): BelongsTo
    {
        return $this->belongsTo(Stock::class, 'stock_id', 'id');
    }
    /**
     * Get the stock that owns the StockDepot
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function depot(): BelongsTo
    {
        return $this->belongsTo(Depot::class, 'depot_id', 'id');
    }

    /**
     * Get all of the suivis for the StockDepot
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function suivis(): HasMany
    {
        return $this->hasMany(DepotSuivi::class, 'stock_depot_id', 'id');
    }

    public function getActivitylogOptions(): LogOptions
    {
      return LogOptions::defaults()
          ->useLogName('stock_depot')
          ->logOnly(["depot_id" , "stock_id" , "quantite","disponible","entre","sortie" , "inactive"])
          ->setDescriptionForEvent(fn(string $eventName) => "{$eventName}");
    }
}
