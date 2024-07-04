<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Projet;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
         User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@material.com',
            'password' => ('secret')
        ]);
        Projet::factory()->count(5)->create()->each(function ($projet) {
            // Associer des partenaires à chaque projet
            $projet->partenaires()->saveMany(User::factory()->count(3)->make());
        });
    }
}
