<?php

use App\Models\Client;
use App\Models\Entreprise;
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
        Schema::create('ligne_ventes', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Client::class)->nullable()->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignIdFor(Entreprise::class)->nullable()->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('num')->unique()->nullable();
            $table->string('statut')->nullable();
            $table->double('ht')->default(0);
            $table->double('ttc')->default(0);
            $table->double('ht_tva')->default(0);
            $table->double('taux_tva')->default(0);
            $table->double('remise')->default(0);
            $table->double('remise_ht')->default(0);
            $table->double('remise_ttc')->default(0);
            $table->date('dateCommande')->nullable();
            $table->date('datePaiement')->nullable();
            $table->date('dateCreation')->nullable();
            $table->double('payer')->default(0);
            $table->double('reste')->default(0);
            $table->string("mois")->default(0);
            $table->text("commentaire")->nullable();
            $table->double("net_payer")->default(0);
            $table->integer("nbrProduits")->default(0);
            $table->integer("qteProduits")->default(0);
            $table->string('mois')->default(date("m-Y"));
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
        Schema::dropIfExists('ligne_ventes');
    }
};
