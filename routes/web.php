<?php

use App\Http\Controllers\AchatController;
use App\Http\Controllers\AchatPaiementController;
use App\Http\Controllers\CategorieController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\DepotController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\EntrepriseController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\FournisseurController;
use App\Http\Controllers\HistoriqueController;
use App\Http\Controllers\LigneAchatController;
use App\Http\Controllers\LigneVenteController;
use App\Http\Controllers\ProduitController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\RapportAchatController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\StockDepotController;
use App\Http\Controllers\StockSuiviController;
use App\Http\Controllers\TauxTvaController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VenteController;
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
  Route::controller(CategorieController::class)->group(function(){
    Route::get('categories-document','document')->name("categorie.document");
    Route::get('categories-export-csv','exportCsv')->name("categorie.csv");
    Route::get('categories-export-xlsx','exportXlsx')->name("categorie.xlsx");
    Route::get('categories-example','example')->name("categorie.example");
    Route::post('categories-import','import')->name("categorie.importer");
  });

  Route::resource('produit', ProduitController::class);
  Route::controller(ProduitController::class)->group(function(){
    Route::get('produits-document','document')->name("produit.document");
    Route::get('produits-exporter-xlsx','exportXlsx')->name("produit.xlsx");
    Route::get('produits-exporter-csv','exportCsv')->name("produit.csv");
    Route::get('produits-example','example')->name("produit.example");
    Route::post('produits-import','import')->name("produit.importer");
  });

  Route::resource("stock",StockController::class)->except(["create"]);
  Route::controller(StockController::class)->group(function(){
    Route::get('stocks-document','document')->name("stock.document");
    Route::get('stocks-exporter-xlsx','exportXlsx')->name("stock.xlsx");
    Route::get('stocks-exporter-csv','exportCsv')->name("stock.csv");
    Route::get('stocks-example','example')->name("stock.example");
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
    Route::get('stockDepots-exporter-xlsx','exportXlsx')->name("stockDepot.xlsx");
    Route::get('stockDepots-exporter-csv','exportCsv')->name("stockDepot.csv");
    Route::get('stockDepots-document','document')->name("stockDepot.document");
  });

  Route::resource("/tauxTva",TauxTvaController::class);
  Route::controller(TauxTvaController::class)->group(function(){
    Route::get('tauxTvas-exporter-xlsx','exportXlsx')->name("tauxTva.xlsx");
    Route::get('tauxTvas-exporter-csv','exportCsv')->name("tauxTva.csv");
    Route::get('tauxTvas-example','example')->name("tauxTva.example");
    Route::get('tauxTvas-document','document')->name("tauxTva.document");
    Route::post('tauxTvas-import','import')->name("tauxTva.importer");
  });


  Route::resource("/depot",DepotController::class);
  Route::controller(DepotController::class)->group(function(){
    Route::get('depots-exporter-xlsx','exportXlsx')->name("depot.xlsx");
    Route::get('depots-exporter-csv','exportCsv')->name("depot.csv");
    Route::get('depots-example','example')->name("depot.example");
    Route::post('depots-import','import')->name("depot.importer");
    Route::get('depots-document','document')->name("depot.document");
    Route::put('depot/{id}/active','active')->name("depot.active");
    Route::put('depot/{id}/inactive','inactive')->name("depot.inactive");
  });

  Route::resource('fournisseur', FournisseurController::class);
  Route::controller(FournisseurController::class)->group(function(){
    Route::get('fournisseurs-example','example')->name("fournisseur.example");
    Route::get('fournisseurs-exportXlsx','exportXlsx')->name("fournisseur.xlsx");
    Route::get('fournisseurs-exportCsv','exportCsv')->name("fournisseur.csv");
    Route::post('fournisseurs-importer','importer')->name("fournisseur.importer");
    Route::get('fournisseurs-document','document')->name("fournisseur.document");
  });

  Route::resource('client', ClientController::class);
  Route::controller(ClientController::class)->group(function(){
    Route::get('clients-example','example')->name("client.example");
    Route::get('clients-exportXlsx','exportXlsx')->name("client.xlsx");
    Route::get('clients-exportCsv','exportCsv')->name("client.csv");
    Route::get('clients-document','document')->name("client.document");
    Route::post('clients-importer','importer')->name("client.importer");
  });


  Route::resource("/ligneAchat",LigneAchatController::class);
  Route::controller(LigneAchatController::class)->group(function () {
    Route::get('ligneAchats-example','example')->name("ligneAchat.example");
    Route::get('ligneAchats-exportXlsx','exportXlsx')->name("ligneAchat.xlsx");
    Route::get('ligneAchats-exportCsv','exportCsv')->name("ligneAchat.csv");
    Route::get('ligneAchats-document','document')->name("ligneAchat.document");
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
    Route::get('ligneVentes-example','example')->name("ligneVente.example");
    Route::get('ligneVentes-exportXlsx','exportXlsx')->name("ligneVente.xlsx");
    Route::get('ligneVentes-exportCsv','exportCsv')->name("ligneVente.csv");
    Route::get('ligneVentes-document','document')->name("ligneVente.document");
  });

  Route::resource("/achatPaiement",AchatPaiementController::class);
  Route::controller(AchatPaiementController::class)->group(function(){
    Route::get('/achatPaiement/{achatPaiement}/minInfo','minInfo')->name("achatPaiement.minInfo");
    Route::get('ligneAchat/{id}/addPaiement','add')->name("achatPaiement.add");
    Route::get('achatPaiement-exportXlsx','exportXlsx')->name("achatPaiement.xlsx");
    Route::get('achatPaiement-exportCsv','exportCsv')->name("achatPaiement.csv");
    Route::get('achatPaiements-document','document')->name("achatPaiement.document");
  });

  Route::resource("/ventePaiement",VentePaiementController::class);
  Route::controller(VentePaiementController::class)->group(function(){
    Route::get('/ligneVente/{id}/addPaiement','add')->name("ventePaiement.add");
    Route::get('/ventePaiement/{ventePaiement}/minInfo','minInfo')->name("ventePaiement.minInfo");
    Route::get('ventePaiement-exportXlsx','exportXlsx')->name("ventePaiement.xlsx");
    Route::get('ventePaiement-exportCsv','exportCsv')->name("ventePaiement.csv");
    Route::get('ventePaiements-document','document')->name("ventePaiement.document");
  });

  Route::controller(DocumentController::class)->group(function(){
    Route::get('documents','index')->name("document.index");
  });
  Route::controller(ExportController::class)->group(function(){
    Route::get('liste-exports','index')->name("export.index");
  });


    Route::resource('role', RoleController::class);
    Route::resource('user', UserController::class);

    Route::resource('entreprise', EntrepriseController::class);
    Route::resource("/achat",AchatController::class);



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


    Route::resource("/ligneAchat",LigneAchatController::class);
    Route::controller(LigneAchatController::class)->group(function () {
      Route::put('/achat-valider/{ligneAchat}','valider')->name("ligneAchat.valider");
      Route::put('/achat-anuller/{ligneAchat}','annuler')->name("ligneAchat.annuler");
      Route::get('/bonCommande/{ligneAchat}','bon')->name("ligneAchat.bon");
      Route::get('/facture/{ligneAchat}','document')->name("ligneAchat.facture");
      Route::get('/facture/{ligneAchat}/demandePrice','demandePrice')->name("ligneAchat.demandePrice");
    });

    Route::resource("/vente",VenteController::class)->except("create");
    Route::controller(VenteController::class)->group(function () {
      Route::get('/vente/{id}/add','add')->name("vente.add");
    });
    Route::controller(RapportAchatController::class)->group(function () {
      Route::get('rapportAchats','index')->name("rapportAchat.index");
      Route::get('rapportAchats/{mois}','show')->name("rapportAchat.show");
    });

    Route::resource("stockSuivi",StockSuiviController::class)->only(["store"]);
    Route::controller(StockController::class)->group(function(){
      Route::get('/new/Stock/{id}','new')->name("stock.new");
    });
    Route::controller(StockSuiviController::class)->group(function(){
      Route::post('/stock/{id}/resign','resign')->name("stockSuivi.resign");
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
