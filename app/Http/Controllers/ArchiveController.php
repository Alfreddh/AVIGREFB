<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class ArchiveController extends Controller
{
    // Fonction pour afficher la liste des projets terminés
    public function index()
    {
        $partnaires = DB::table('users')->where('type', 'Partenaire')->get();
        $projets = DB::table('projets')
            ->leftJoin('projetutilisateurs', 'projets.id', '=', 'projetutilisateurs.idprojet')
            ->leftJoin('users', 'projetutilisateurs.idutilisateur', '=', 'users.id')
            ->select('projets.*', 'users.name as partenaire_name', 'users.email as partenaire_email')
            ->where('projets.statut', 'Terminé')
            ->get()
            ->groupBy('id');

        return view('pages.archives', compact('projets'));
    }

    // Fonction pour supprimer un projet
    public function delete($id)
    {
        // Supprimer les associations de partenaires avec le projet
        DB::table('projetutilisateurs')->where('idprojet', $id)->delete();
        
        // Supprimer les activités associées au projet
        DB::table('activites')->where('projet_id', $id)->delete();

        // Supprimer le projet lui-même
        DB::table('projets')->where('id', $id)->delete();

        return redirect()->route('archives.index')->with('success', 'Projet supprimé avec succès.');
    }
}
