<?php

use App\Models\Entreprise;
use App\Models\Fournisseur;
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
        Schema::create('ligne_achats', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Fournisseur::class)->nullable()->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignIdFor(Entreprise::class)->nullable()->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('num_achat')->unique()->nullable();
            $table->string('statut')->nullable();
            $table->double('ht')->default(0);
            $table->double('ttc')->default(0);
            $table->double('net_payer')->default(0);
            $table->integer('taux_tva')->default(0);
            $table->integer('nombre_achats')->default(0);
            $table->date('date_achat')->nullable();
            $table->date('dateCreation')->nullable();
            $table->date('datePaiement')->nullable();
            $table->double('payer')->default(0);
            $table->double('mt_tva')->default(0);
            $table->double('reste')->default(0);
            $table->string('mois')->default(date("m-Y"));
            $table->text('commentaire')->nullable();
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
        Schema::dropIfExists('ligne_achats');
    }
};
