<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Nombre total de projets
        $nbrprojets = DB::table('projets')->count();

        // Nombre d'utilisateurs de type partenaire
        $nbpartenaire = DB::table('users')->where('type', 'Partenaire')->count();

        // Nombre de projets terminés
        $projetstermines = DB::table('projets')->where('statut', 'Terminé')->count();

        // Liste des 6 récents projets avec les partenaires associés
        $projets = DB::table('projets')
            ->leftJoin('projetutilisateurs', 'projets.id', '=', 'projetutilisateurs.idprojet')
            ->leftJoin('users', 'projetutilisateurs.idutilisateur', '=', 'users.id')
            ->select('projets.*', 'users.name as partenaire_name', 'users.email as partenaire_email')
            ->orderBy('projets.created_at', 'desc')
            ->take(6)
            ->get()
            ->groupBy('id');

        return view('dashboard.index', compact('nbrprojets', 'nbpartenaire', 'projetstermines', 'projets'));
    }
}
