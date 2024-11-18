<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Produit extends Model
{
    use HasFactory;
    protected $table = "produits";
    protected $guarded = [];
    use SoftDeletes,LogsActivity;
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->uselogName('produit')
            ->logAll()
            ->setDescriptionForEvent(fn(string $eventName) => "{$eventName}");
    }
    /**
     * Get the categorie that owns the Produit
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function categorie(): BelongsTo
    {
        return $this->belongsTo(Categorie::class, 'categorie_id', 'id');
    }

    /**
     * Get the stock associated with the Produit
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function stock(): HasOne
    {
        return $this->hasOne(Stock::class, 'produit_id', 'id');
    }

}
