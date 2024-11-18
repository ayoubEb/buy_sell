<?php

use App\Models\LigneVente;
use App\Models\Produit;
use App\Models\Vente;
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
        Schema::create('ventes', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(LigneVente::class)->nullable()->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignIdFor(Produit::class)->nullable()->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->integer('quantite')->default(1);
            $table->double('remise')->nullable();
            $table->double('prix')->nullable();
            $table->double('montant')->nullable();
            $table->datetime("deleted_at")->nullable();
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
        Schema::dropIfExists('ventes');
    }
};
