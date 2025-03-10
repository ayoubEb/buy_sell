<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Stock extends Model
{
    use HasFactory , LogsActivity;
    protected $table="stocks";
    protected $guarded = [];
    use SoftDeletes;
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->uselogName('stock')
            ->logAll()
            ->setDescriptionForEvent(fn(string $eventName) => "{$eventName}");
    }
    /**
     * Get the produit that owns the Stock
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function produit(): BelongsTo
    {
        return $this->belongsTo(Produit::class, 'produit_id');
    }

    /**
     * Get all of the history for the Stock
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function suivis(): HasMany
    {
        return $this->hasMany(StockSuivi::class);
    }

    /**
     * The depot that belong to the Stock
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function depots(): BelongsToMany
    {
        return $this->belongsToMany(Depot::class, 'stock_depots', 'stock_id', 'depot_id')->withPivot(["quantite","entre","sortie","disponible","check_default"]);
    }

}
