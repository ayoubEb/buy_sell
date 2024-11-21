<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AchatCheque extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = "achat_cheques";
    protected $guarded = [];
}
