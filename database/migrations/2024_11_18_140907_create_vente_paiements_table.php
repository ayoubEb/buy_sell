<?php

use App\Models\LigneVente;
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
        Schema::create('vente_paiements', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(LigneVente::class)->nullable()->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->string("num")->nullable()->unique();
            $table->string("numero_operation")->nullable()->unique();
            $table->string("type_paiement")->nullable();
            $table->string("statut")->nullable();
            $table->double("payer")->nullable();
            $table->date("date_paiement")->nullable();
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
        Schema::dropIfExists('vente_paiements');
    }
};
