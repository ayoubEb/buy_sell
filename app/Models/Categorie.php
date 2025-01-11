<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Categorie extends Model
{
    use HasFactory,SoftDeletes,LogsActivity;
    protected $table="categories";
    protected $guarded = [];
    // protected $dates = ["deleted_at"];
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->uselogName('categorie')
            ->logOnly(["nom","description"])
            ->setDescriptionForEvent(fn(string $eventName) => "{$eventName}");
    }


}
