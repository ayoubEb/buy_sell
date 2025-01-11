<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Depot extends Model
{
    use HasFactory,SoftDeletes , LogsActivity;
    protected $table = "depots";
    protected $guarded = [];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->uselogName('depot')
            ->logOnly(["num_depot","adresse","quantite","disponible","entre","statut","sortie","inactive"])
            ->setDescriptionForEvent(fn(string $eventName) => "{$eventName}");
    }
    /**
     * The depot that belong to the Stock
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function stocks(): BelongsToMany
    {
        return $this->belongsToMany(Stock::class, 'stock_depots', 'stock_id', 'depot_id')->withPivot(["quantite","entre","sortie","disponible"]);
    }
}
