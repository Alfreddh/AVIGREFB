<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CheckActivitesTermination extends Command
{
    protected $signature = 'activites:check-termination';

    protected $description = 'Vérifie périodiquement les activités et termine les projets si nécessaire';

    public function handle()
    {
        $projetsEnCours = DB::table('projets')->where('statut', 'En cours')->get();

        foreach ($projetsEnCours as $projet) {
            $activitesEnCours = DB::table('activites')->where('projet_id', $projet->id)->where('status', 'En cours')->count();

            if ($activitesEnCours == 0) {
                // Mettre à jour le statut du projet à "Terminé"
                DB::table('projets')->where('id', $projet->id)->update(['statut' => 'Terminé']);

                $this->info('Projet terminé : ' . $projet->nom);
            }
        }
    }
}
