<?php

use App\Models\LigneAchat;
use App\Models\Produit;
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
        Schema::create('achats', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(LigneAchat::class)->nullable()->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignIdFor(Produit::class)->nullable()->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->double("montant")->nullable();
            $table->integer("quantite")->nullable();
            $table->double("remise")->nullable();
            $table->double("prix")->nullable();
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
        Schema::dropIfExists('achats');
    }
};
