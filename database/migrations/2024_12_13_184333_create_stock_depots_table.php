<?php

use App\Models\Depot;
use App\Models\Stock;
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
        Schema::create('stock_depots', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Stock::class)->nullable()->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignIdFor(Depot::class)->nullable()->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->integer("quantite")->default(0);
            $table->integer("inactive")->default(0);
            $table->integer("entre")->default(0);
            $table->integer("sortie")->default(0);
            $table->integer("disponible")->default(0);
            $table->boolean("check_default")->default(0);
            $table->boolean("statut")->default(0);
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
        Schema::dropIfExists('stock_depots');
    }
};
