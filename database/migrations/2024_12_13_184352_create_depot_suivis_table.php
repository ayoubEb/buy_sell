<?php

use App\Models\StockDepot;
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
        Schema::create('depot_suivis', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(StockDepot::class)->nullable()->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->date("date_suivi")->nullable();
            $table->integer("quantite")->default(0);;
            $table->string("operation")->nullable();
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
        Schema::dropIfExists('depot_suivis');
    }
};
