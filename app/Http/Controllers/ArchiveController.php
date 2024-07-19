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
        $archives = DB::table('archives')->get();
        $villages = DB::table('villages')->get();
        $zones = DB::table('zones')->get();
        $projets = DB::table('projets')
            ->leftJoin('projetutilisateurs', 'projets.id', '=', 'projetutilisateurs.idprojet')
            ->leftJoin('users', 'projetutilisateurs.idutilisateur', '=', 'users.id')
            ->select('projets.*', 'users.name as partenaire_name', 'users.email as partenaire_email')
            ->where('projets.statut', 'Terminé')
            ->get()
            ->groupBy('id');

        return view('pages.archives', compact('projets', 'archives', 'villages', 'zones'));
    }
    public function getVillagesByZone(Request $request)
    {
        $zoneId = $request->input('zone_id');
        $villages = DB::table('villages')->where('zone_id', $zoneId)->get();

        $options = '<option value="">Select Village</option>'; // Default option
        foreach ($villages as $village) {
            $options .= '<option value="' . $village->id . '">' . $village->libelle . '</option>';  // Adjust 'name' if needed
        }

        return response()->json(['options' => $options]);
    }




    public function create()
    {
        $villages = DB::table('villages')->get();
        $zones = DB::table('zones')->get();
        return view('pages.modal.create-archive', compact('villages', 'zones'));
    }

    public function store(Request $request)
    {
        $rapport = $request->file('rapport');
        if ($rapport !== null){
        $rapportname = time().'.'.$rapport->getClientOriginalExtension();
        $rapport_path = $rapport->storeAs('rapports', $rapportname, 'public');
        }
        DB::table('archives')->insert([
            'nom' => $request->input('nom'),
            'description' => $request->input('description'),
            'zone_id' => $request->input('zone_id'),
            'village_id' => $request->input('village_id'),
            'rapport_path' => $rapport_path,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('archives.index');
    }

    public function edit($id)
    {
        $archive = DB::table('archives')->where('id', $id)->first();
        $villages = DB::table('villages')->get();
        $zones = DB::table('zones')->get();
        return view('archives.edit', compact('archive', 'villages', 'zones'));
    }

    public function update(Request $request, $id)
    {
        DB::table('archives')
            ->where('id', $id)
            ->update([
                'nom' => $request->input('nom'),
                'description' => $request->input('description'),
                'village_id' => $request->input('village_id'),
                'zone_id' => $request->input('zone_id'),
                'rapport_path' => $request->input('rapport_path'),
                'updated_at' => now(),
            ]);

        return redirect()->route('archives.index');
    }

    public function destroy($id)
    {
        DB::table('archives')->where('id', $id)->delete();
        return redirect()->route('archives.index');
    }
}
