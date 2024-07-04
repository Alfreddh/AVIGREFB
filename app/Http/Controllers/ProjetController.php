<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjetFormRequest;
use App\Models\Projet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProjetController extends Controller
{
    public function index()
    {
        $partnaires = DB::table('users')->where('type', 'Partenaire')->get();
        
        $projets = DB::table('projets')
            ->leftJoin('projetutilisateurs', 'projets.id', '=', 'projetutilisateurs.idprojet')
            ->leftJoin('users', 'projetutilisateurs.idutilisateur', '=', 'users.id')
            ->select('projets.*', 'users.name as partenaire_name', 'users.email as partenaire_email')
            ->get()
            ->groupBy('id');
            
            foreach ($projets as $id => $projetGroup) {
                foreach ($projetGroup as $projet) {
                    $nbractivites = DB::table('activites')
                        ->where('projet_id', $projet->id)
                        ->count();
    
                    $nbractivites_terminees = DB::table('activites')
                        ->where('projet_id', $projet->id)
                        ->where('status', 'Terminée')
                        ->count();
    
                    $projet->nbractivites = $nbractivites;
                    $projet->nbractivites_terminees = $nbractivites_terminees;

                    $projet->pourcentage = $nbractivites > 0 ? ($nbractivites_terminees * 100) / $nbractivites : 0;
                    //dd($projet->nbractivites_terminees);
                }
            }
            
        return view('pages.projets', compact('projets', 'partnaires'));
    }

    public function changerRapport(Request $request, $projetId, $activiteId)
    {
        $request->validate([
            'nouveau_rapport' => 'required|mimes:pdf|max:2048',
        ]);

        $activite = DB::table('activites')->where('id', $activiteId)->first();

        // Supprimer l'ancien rapport
        if ($activite->rapport) {
            Storage::delete($activite->rapport);
        }

        // Téléverser le nouveau rapport
        $rapport = $request->file('nouveau_rapport');
        $rapportname = time().'.'.$rapport->getClientOriginalExtension();
        $path = $rapport->storeAs('rapports', $rapportname, 'public');

        // Mettre à jour le rapport dans la base de données
        DB::table('activites')->where('id', $activiteId)->update([
            'rapport' => $path,
        ]);

        return redirect()->route('projets.show', $projetId)->with('success', 'Le rapport a été changé avec succès.');
    }

    public function create()
    {
        return view('projets.create');
    }

    public function store(Request $request)
    {
        $image = $request->file('image');
        $imageName = time().'.'.$image->getClientOriginalExtension();
        $imagePath = $image->storeAs('images', $imageName, 'public');

        $rapport = $request->file('rapport');
        $rapportname = time().'.'.$rapport->getClientOriginalExtension();
        $rapport_path = $rapport->storeAs('rapports', $rapportname, 'public');
        //dd($imagePath);   
        $request->validate([
            'nom' => 'required|string|max:255',
            'description' => 'nullable|string',
            'budget' => 'required',
            'image' => 'nullable',
            'rapport' => 'nullable',
            'partenaire' => 'required|exists:users,id', 
        ]);
        //$imagePath = null;
        // Vérifier si un fichier image est présent dans la requête
        $projet = Projet::create([
            'nom' => $request->input('nom'),
            'description' => $request->input('description'),
            'budget' => $request->input('budget'),
            'datedeb' => $request->input('datedeb'),
            'datefin' => $request->input('datefin'),
            'image_path' => $imagePath,
            'rapport' => $rapport_path,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        DB::table('projetutilisateurs')->insert([
            'idprojet' => $projet->id,
            'idutilisateur' => $request->input('partenaire'),
        ]);

        return redirect()->route('projets')->with('success', 'Projet créé avec succès.');
    }
        

    public function show($id)
    {
        $projet = DB::table('projets')
        ->where('projets.id', $id)
        ->leftJoin('projetutilisateurs', 'projets.id', '=', 'projetutilisateurs.idprojet')
        ->leftJoin('users', 'projetutilisateurs.idutilisateur', '=', 'users.id')
        ->select('projets.*', 'users.name as partenaire_name', 'users.email as partenaire_email')
        ->get();
        $activites = DB::table('activites')->where('projet_id', $id)->get();

        return view('pages.projet_detail', compact('projet', 'activites'));
    }

    public function edit($id)
    {
        $projet = Projet::findOrFail($id);
        return view('projets.edit', compact('projet'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable',
            'rapport' => 'nullable',
            'budget' => 'nullable' // Exemple de validation pour le rapport PDF
            // Ajoutez ici la validation pour les autres attributs du projet
        ]);
        

        DB::beginTransaction();

        try {
            $projet = DB::table('projets')->where('id', $id)->first();

            if (!$projet) {
                throw new \Exception('Projet introuvable.');
            }

            // Récupérer les anciennes valeurs
            $oldValues = [
                'nom' => $projet->nom,
                'description' => $projet->description,
                'image_path' => $projet->image_path,
                'budget' => $projet->budget,
                'rapport' => $projet->rapport
            ];

            // Initialiser les données à mettre à jour
            if ($request->hasFile('rapport')){
                $rapport = $request->file('rapport');
                $rapportname = time().'.'.$rapport->getClientOriginalExtension();
                $rapport_path = $rapport->storeAs('rapports', $rapportname, 'public');
            }
            if ($request->hasFile('image')){
                $image = $request->file('image');
                //dd($image);
                $imagename = time().'.'.$image->getClientOriginalExtension();
                $image_path = $image->storeAs('images', $imagename, 'public');
            }
            
            $updateData = [];
            

            // Comparer et mettre à jour les champs uniquement si les valeurs ont changé
            if ($request->input('nom') !== $oldValues['nom']) {
                $updateData['nom'] = $request->input('nom');
            }


            
            if ($rapport_path !== $oldValues['rapport']) {
                Storage::delete('public/' . $oldValues['rapport']);
                $updateData['rapport'] = $rapport_path;
            }

            // Vérifiez si une nouvelle image a été téléchargée
            if ($request->input('description') !== $oldValues['description']) {
                $updateData['description'] = $request->input('description');
            }
            if ($request->input('budget') !== $oldValues['budget']) {
                $updateData['budget'] = $request->input('budget');
            }
            if ($image_path !== $oldValues['image_path']) {
                Storage::delete('public/' . $oldValues['image_path']);
                $updateData['image_path'] = $image_path;
            }
            

            // Vérifiez si un nouveau rapport PDF a été téléchargé
            

            // Mettre à jour la base de données si des champs ont changé
            if (!empty($updateData)) {
                DB::table('projets')->where('id', $id)->update($updateData);
            }

            DB::commit();
            

            return redirect()->route('projets.index')->with('success', 'Projet mis à jour avec succès.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Une erreur est survenue lors de la mise à jour du projet.');
        }
    }


    public function destroy($id)
    {
        $projet = Projet::findOrFail($id);
        $projet->delete();

        return redirect()->route('projets.index')->with('success', 'Projet supprimé avec succès.');
    }

    public function createActivite($projet_id)
    {
        $projet = DB::table('projets')->where('id', $projet_id)->first();
        return view('activites.create', compact('projet'));
    }
    public function addActivite(Request $request, $projet_id)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'description' => 'required|string',
            'date_debut_estime' => 'nullable',
            'date_fin_estime' => 'nullable',
            //'date_fin_estime' => 'nullable'
        ]);
        //dd('bien');
        DB::table('activites')->insert([
            'projet_id' => $projet_id,
            'nom' => $request->nom,
            'description' => $request->description,
            'date_debut_estime' => $request->date_debut_estime,
            'date_fin_estime' => $request->date_fin_estime,

            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('projets.show', $projet_id);
    }
    public function terminerActivite(Request $request, $projet_id, $activite_id)
    {
        $request->validate([
            'rapport' => 'required|file|mimes:pdf|max:2048',
        ]);
        $rapport = $request->file('rapport');
        $rapportname = time().'.'.$rapport->getClientOriginalExtension();
        $path = $rapport->storeAs('rapports', $rapportname, 'public');
        
        DB::table('activites')->where('id', $activite_id)->update([
            'status' => 'terminée',
            'rapport' => $path,
            'updated_at' => now(),
        ]);

        return redirect()->route('projets.show', $projet_id);
    }
    public function commencerActivite(Request $request, $projet_id, $activite_id)
    {
         
        DB::table('activites')->where('id', $activite_id)->update([
            'status' => 'En cours',
            'updated_at' => now(),
        ]);

        return redirect()->route('projets.show', $projet_id);
    }
    public function destroyActivite($projet_id, $activite_id)
    {
        $activite = DB::table('activites')->where('id', $activite_id)->first();

        if ($activite->rapport) {
            Storage::delete($activite->rapport);
        }

        DB::table('activites')->where('id', $activite_id)->delete();

        return redirect()->route('projets.show', $projet_id);
    }
}
