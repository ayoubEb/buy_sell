<?php

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
        Schema::create('stock_suivis', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Stock::class)->nullable()->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->string("fonction")->nullable();
            $table->integer("quantite")->nullable();
            $table->date("date_suivi")->nullable();
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
        Schema::dropIfExists('stock_suivis');
    }
};
