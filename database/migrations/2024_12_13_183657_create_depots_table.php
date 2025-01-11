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
        Schema::create('depots', function (Blueprint $table) {
            $table->id();
            $table->string("num_depot")->nullable()->unique();
            $table->string("adresse")->nullable();
            $table->integer("quantite")->default(0);
            $table->integer("disponible")->default(0);
            $table->integer("entre")->default(0);
            $table->boolean("statut")->default(0);
            $table->integer("sortie")->default(0);
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
        Schema::dropIfExists('depots');
    }
};
