<?php

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
        Schema::create('stocks', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Produit::class)->nullable()->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->string("num")->nullable()->unique();
            $table->integer("quantite")->default(0);
            $table->integer("disponible")->default(0);
            $table->integer("reste")->default(0);
            $table->date("date_stock")->nullable();
            $table->integer("min")->default(0);
            $table->integer("sortie")->default(0);
            $table->integer("max")->default(0);
            $table->integer('qte_achat')->default(0);
            $table->integer('qte_alert')->default(0);
            $table->integer('qte_vente')->default(0);
            $table->integer("qte_augmenter")->default(0);
            $table->integer("qte_achatRes")->default(0);
            $table->integer("qte_venteRes")->default(0);
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
        Schema::dropIfExists('stocks');
    }
};
