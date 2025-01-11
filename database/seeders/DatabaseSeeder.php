<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        $this->call(PermissionTableSeeder::class);
        $this->call(AdminSeeder::class);
        $this->call(CategorieSeeder::class);
        $this->call(FournisseurSeeder::class);
        $this->call(ProduitSeeder::class);
        $this->call(TauxSeeder::class);
        $this->call(ClientSeeder::class);
        $this->call(BanqueSeeder::class);
        $this->call(EntrepriseSeeder::class);
        $this->call(DepotSeeder::class);
        $this->call(StockSeeder::class);
        $this->call(ActivityInitialSeeder::class);
    }
}
