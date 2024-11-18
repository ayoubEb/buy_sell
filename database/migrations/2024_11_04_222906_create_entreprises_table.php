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
        Schema::create('entreprises', function (Blueprint $table) {
            $table->id();
            $table->string('logo')->nullable();
            $table->string('raison_sociale')->nullable();
            $table->string('rc')->nullable();
            $table->string('ice')->nullable();
            $table->string('if')->nullable();
            $table->string("patente")->nullable();
            $table->string("site")->nullable();
            $table->integer("cnss")->nullable();
            $table->string('adresse')->nullable();
            $table->string('ville')->nullable();
            $table->string('email')->nullable();
            $table->string('code_postal')->nullable();
            $table->string('telephone')->nullable();
            $table->string('fix')->nullable();
            $table->text('description')->nullable();
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
        Schema::dropIfExists('entreprises');
    }
};
