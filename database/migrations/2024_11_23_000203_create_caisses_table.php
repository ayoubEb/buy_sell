<?php

use App\Models\CategorieCaisse;
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
        Schema::create('caisses', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(CategorieCaisse::class)->nullable()->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->double("montant")->default(0);
            $table->date("dateCaisse")->nullable();
            $table->string("statut")->nullable();
            $table->string("operation")->nullable();
            $table->text("observation")->nullable();
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
        Schema::dropIfExists('caisses');
    }
};
