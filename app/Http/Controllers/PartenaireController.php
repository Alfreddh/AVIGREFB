<?php
namespace App\Http\Controllers;

use App\Models\Partenaire;
use App\Models\Projet;
use Illuminate\Http\Request;

class PartenaireController extends Controller
{
    public function index($projetId)
    {
        $projet = Projet::findOrFail($projetId);
        $partenaires = $projet->partenaires;
    }
}
