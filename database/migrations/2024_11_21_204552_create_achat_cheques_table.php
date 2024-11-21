<?php

use App\Models\AchatPaiement;
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
        Schema::create('achat_cheques', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(AchatPaiement::class)->nullable()->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->string("banque")->nullable();
            $table->string("numero")->nullable()->unique();
            $table->date("date_cheque")->nullable();
            $table->date("date_enquisement")->nullable();
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
        Schema::dropIfExists('achat_cheques');
    }
};
