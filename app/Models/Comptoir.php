<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Comptoir extends Model
{
    use HasFactory , SoftDeletes, LogsActivity;
    protected $table = "comptoirs";
    protected $guarded = [];
    // protected $dates = ["deleted_at"];
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->uselogName('comptoir')
            ->logOnly(["num","statut"])
            ->setDescriptionForEvent(fn(string $eventName) => "{$eventName}");
    }

}
