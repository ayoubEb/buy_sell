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
        Schema::create('fournisseurs', function (Blueprint $table) {
            $table->id();
            $table->string("identifiant")->nullable()->unique();
            $table->string("raison_sociale")->nullable();
            $table->string("adresse")->nullable();
            $table->string("ville")->nullable();
            $table->string("rc")->nullable()->unique();
            $table->string("ice")->nullable()->unique();
            $table->integer("code_postal")->nullable();
            $table->string("telephone")->nullable();
            $table->string("fix")->nullable();
            $table->string("pays")->nullable();
            $table->string("email")->nullable()->unique();
            $table->double("montant")->default(0);
            $table->double("payer")->default(0);
            $table->double("reste")->default(0);
            $table->double("montant_demande")->default(0);
            $table->string("moisCreation")->nullable();
            $table->datetime("dateCreation")->nullable();
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
        Schema::dropIfExists('fournisseurs');
    }
};
