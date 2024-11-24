<?php

use App\Models\Categorie;
use App\Models\Marque;
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
        Schema::create('produits', function (Blueprint $table) {
            $table->id();
            $table->string('image')->nullable();
            $table->foreignIdFor(Categorie::class)->nullable()->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignIdFor(Marque::class)->nullable()->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('reference')->nullable()->unique();
            $table->string('designation')->nullable();
            $table->boolean('statut')->default(0);
            $table->text('description')->nullable();
            $table->double('prix_achat')->default(0);
            $table->double('prix_vente')->default(0);
            $table->double('prix_revient')->default(0);
            $table->integer('quantite')->default(0);
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
        Schema::dropIfExists('produits');
    }
};
