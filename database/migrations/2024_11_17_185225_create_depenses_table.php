<?php

use App\Models\CategorieDepense;
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
    Schema::create('depenses', function (Blueprint $table) {
      $table->id();
      $table->foreignIdFor(CategorieDepense::class)->nullable()->constrained()->cascadeOnDelete()->cascadeOnUpdate();
      $table->double("montant")->default(0);
      $table->date("dateDepense")->nullable();
      $table->text("description")->nullable();
      $table->string("statut")->nullable();
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
    Schema::dropIfExists('depenses');
  }
};
