<?php

use App\Http\Controllers\AchatController;
use App\Http\Controllers\AchatPaiementController;
use App\Http\Controllers\CaisseController;
use App\Http\Controllers\CategorieCaisseController;
use App\Http\Controllers\CategorieController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ComptoirController;
use App\Http\Controllers\DepotController;
use App\Http\Controllers\EntrepriseController;
use App\Http\Controllers\FournisseurController;
use App\Http\Controllers\HistoriqueController;
use App\Http\Controllers\LigneAchatController;
use App\Http\Controllers\LigneRapportController;
use App\Http\Controllers\LigneVenteController;
use App\Http\Controllers\LivraisonController;
use App\Http\Controllers\MarqueController;
use App\Http\Controllers\ProduitController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\RapportAchatController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\StockDepotController;
use App\Http\Controllers\StockSuiviController;
use App\Http\Controllers\TauxTvaController;
use App\Http\Controllers\UniteMesureController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VenteComptoirController;
use App\Http\Controllers\VenteController;
use App\Http\Controllers\VenteLivraisonController;
use App\Http\Controllers\VentePaiementController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::group(['middleware' => ['auth']], function() {

    Route::resource("categorie",CategorieController::class);
    Route::resource('role', RoleController::class);
    Route::resource('user', UserController::class);
    Route::resource('produit', ProduitController::class);
    Route::resource('fournisseur', FournisseurController::class);
    Route::resource('client', ClientController::class);
    Route::resource('entreprise', EntrepriseController::class);
    Route::resource("/tauxTva",TauxTvaController::class);
    Route::resource("/achat",AchatController::class);
    Route::resource("/achatPaiement",AchatPaiementController::class);
    Route::resource("/ventePaiement",VentePaiementController::class);
    Route::resource('comptoir', ComptoirController::class);
    Route::resource('venteComptoir', VenteComptoirController::class);
    Route::resource("depot",DepotController::class);
    Route::controller(DepotController::class)->group(function(){
      Route::put('depot/{id}/active','active')->name("depot.active");
      Route::put('depot/{id}/inactive','inactive')->name("depot.inactive");
    });

    Route::controller(StockDepotController::class)->group(function(){
      Route::get('stockDepots','index')->name("stockDepot.index");
      Route::get('stockDepot/{stockDepot}/edit','edit')->name("stockDepot.edit");
      Route::put('stockDepot/{stockDepot}','update')->name("stockDepot.update");
      Route::post('stockDepots','store')->name("stockDepot.store");
      Route::get('stock/{id}/depot','depots')->name("stockDepot.add");
      Route::get('stockDepot/{stockDepot}','show')->name("stockDepot.show");
      Route::put('stockDepot/{id}/inactive','inactive')->name("stockDepot.inactive");
      Route::put('stockDepot/{id}/active','active')->name("stockDepot.active");
    });
    Route::controller(ProduitController::class)->group(function(){
      Route::get('/getProduit','getProduit')->name("produit.info");
    });
    // Route::controller(VenteLivraisonController::class)->group(function(){
    //   Route::get('vente/{id}/addLivraison','add')->name("venteLivraison.add");
    // });
    Route::get('/ligneAchat/{id}/addProduits',[AchatController::class,'add'])->name("achat.new");
    Route::controller(AchatPaiementController::class)->group(function(){
      Route::get('/achatPaiement/{achatPaiement}/minInfo','minInfo')->name("achatPaiement.minInfo");
      Route::get('ligneAchat/{id}/addPaiement','add')->name("achatPaiement.add");
    });
    Route::controller(VentePaiementController::class)->group(function(){
      Route::get('/ligneVente/{id}/addPaiement','add')->name("ventePaiement.add");
      Route::get('/ventePaiement/{ventePaiement}/minInfo','minInfo')->name("ventePaiement.minInfo");
    });
    Route::resource("/ligneAchat",LigneAchatController::class);
    Route::controller(LigneAchatController::class)->group(function () {
      Route::put('/achat-valider/{ligneAchat}','valider')->name("ligneAchat.valider");
      Route::put('/achat-anuller/{ligneAchat}','annuler')->name("ligneAchat.annuler");
      Route::get('/bonCommande/{ligneAchat}','bon')->name("ligneAchat.bon");
      Route::get('/facture/{ligneAchat}','document')->name("ligneAchat.facture");
      Route::get('/facture/{ligneAchat}/demandePrice','demandePrice')->name("ligneAchat.demandePrice");
    });
    Route::resource("ligneVente",LigneVenteController::class);
    Route::controller(LigneVenteController::class)->group(function () {
      Route::put('vente-valider/{ligneVente}','valider')->name("ligneVente.valider");
      Route::get('ligneVente/{ligneVente}/devis','devis')->name("ligneVente.devis");
      Route::get('ligneVente/{ligneVente}/facture','facture')->name("ligneVente.facture");
      Route::get('ligneVente/{ligneVente}/facture-preforma','facture_preforma')->name("ligneVente.facturePreforma");
    });
    Route::resource("/vente",VenteController::class)->except("create");
    Route::controller(VenteController::class)->group(function () {
      Route::get('/vente/{id}/add','add')->name("vente.add");
    });
    Route::controller(RapportAchatController::class)->group(function () {
      Route::get('rapportAchats','index')->name("rapportAchat.index");
      Route::get('rapportAchats/{mois}','show')->name("rapportAchat.show");
    });
    Route::resource("stock",StockController::class)->except(["create"]);
    Route::resource("stockSuivi",StockSuiviController::class)->only(["store"]);
    Route::controller(StockController::class)->group(function(){
      Route::get('/new/Stock/{id}','new')->name("stock.new");
    });
    Route::controller(StockSuiviController::class)->group(function(){
      Route::post('/stock/{id}/resign','resign')->name("stockSuivi.resign");
    });
    Route::controller(CategorieController::class)->group(function(){
      Route::get('/categories/document','document')->name("catgeorie.document");
    });
    Route::controller(ProfilController::class)->group(function(){
      Route::get('/profil/{id}','monCompte')->name("profil.show");
      Route::get('/profil/{id}/edit','edit')->name("profil.edit");
      Route::put('/profil/{id}','update')->name("profil.update");
    });
    Route::controller(HistoriqueController::class)->group(function(){
      Route::get('/historiques/produits','produits')->name("historique.produits");
      Route::get('/historiques/categories','categories')->name("historique.categories");
      Route::get('/historiques/stocks','stocks')->name("historique.stocks");
      Route::get('/historiques/fournisseurs','fournisseurs')->name("historique.fournisseurs");
      Route::get('/historiques/ligneAchats','ligneAchats')->name("historique.ligneAchats");
      Route::get('/historiques/users','users')->name("historique.users");
      Route::get('/historiques/entreprises','entreprises')->name("historique.entreprises");
      Route::get('/historiques/achatPaiements','achatPaiements')->name("historique.achatPaiements");
    });

});
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
