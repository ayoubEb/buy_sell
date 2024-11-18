<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Entreprise extends Model
{
    use HasFactory,SoftDeletes,LogsActivity;
    protected $table='entreprises';
    protected $guarded = [];
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->uselogName('entreprise')
            ->logAll()
            ->setDescriptionForEvent(fn(string $eventName) => "{$eventName}");
    }

}
