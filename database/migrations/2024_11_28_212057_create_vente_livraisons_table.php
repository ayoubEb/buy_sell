<?php

use App\Models\LigneVente;
use App\Models\Livraison;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vente_livraisons', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(LigneVente::class)->nullable()->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignIdFor(Livraison::class)->nullable()->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->string("num")->nullable()->unique();
            $table->date("date_livraison")->nullable();
            $table->date("date_depot")->nullable();
            $table->date("date_reception")->nullable();
            $table->integer("nbr_jours")->nullable();
            $table->string("statut")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vente_livraisons');
    }
};
