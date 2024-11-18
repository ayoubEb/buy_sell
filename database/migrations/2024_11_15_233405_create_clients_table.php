<?php

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
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('identifiant')->nullable();
            $table->string('raison_sociale')->nullable();
            $table->string('adresse')->nullable();
            $table->string('email')->unique()->nullable();
            $table->string('ville')->nullable();
            $table->string("ice",16)->nullable();
            $table->string("if_client",16)->nullable();
            $table->string("rc",16)->nullable();
            $table->string('telephone')->nullable();
            $table->integer('code_postal')->nullable();
            $table->string('activite')->nullable();
            $table->double('montant')->default(0);
            $table->double('payer')->default(0);
            $table->double('montant_devis')->default(0);
            $table->double('solde')->default(0);
            $table->double('reste')->default(0);
            $table->string('moisCreation',7)->nullable();
            $table->date('dateCreation')->nullable();
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
        Schema::dropIfExists('clients');
    }
};
