<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            'role-list','role-nouveau','role-modification','role-suppression','role-display',
            'livraison-list','livraison-nouveau','livraison-modification','livraison-suppression','livraison-display',
            'categorieCaisse-list','categorieCaisse-nouveau','categorieCaisse-modification','categorieCaisse-suppression','categorieCaisse-display',
            'caisse-list','caisse-nouveau','caisse-modification','caisse-suppression','caisse-display',
            'produit-list','produit-nouveau','produit-modification','produit-suppression','produit-display',
            'user-list','user-nouveau','user-modification','user-suppression','user-display',
            'fournisseur-list','fournisseur-nouveau','fournisseur-modification','fournisseur-suppression','fournisseur-display',
            'client-list','client-nouveau','client-modification','client-suppression','client-display',
            'ligneVente-list','ligneVente-nouveau','ligneVente-modification','ligneVente-display',
            'vente-list','vente-nouveau','vente-modification','vente-suppression',
            'entreprise-list','entreprise-nouveau','entreprise-modification','entreprise-suppression','entreprise-display',
            'ligneAchat-list','ligneAchat-nouveau','ligneAchat-modification','ligneAchat-display',
            'achat-nouveau','achat-modification','achat-suppression','achat-display',
            'achatPaiement-list','achatPaiement-nouveau','achatPaiement-modification','achatPaiement-suppression','achatPaiement-display',
            'ventePaiement-list','ventePaiement-nouveau','ventePaiement-modification','ventePaiement-suppression','ventePaiement-display',
            'categorie-list','categorie-nouveau','categorie-modification','categorie-suppression','categorie-display',
            'stock-list','stock-nouveau','stock-modification','stock-display',
            'stockSuivi-list','stockSuivi-nouveau',
            'marque-list','marque-nouveau','marque-mofication','marque-suppression',
            'tauxTva-list','tauxTva-nouveau','tauxTva-modification','tauxTva-suppression',
         ];





         foreach ($permissions as $permission) {

              Permission::create(['name' => $permission]);

         }
    }
}
