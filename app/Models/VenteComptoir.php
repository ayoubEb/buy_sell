<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VenteComptoir extends Model
{
    use HasFactory;
    protected $table = "vente_comptoirs";
    protected $guarded = [];
}
