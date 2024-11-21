<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VenteCheque extends Model
{
  use HasFactory,SoftDeletes;
  protected $table = "vente_cheques";
  protected $guarded = [];
}
