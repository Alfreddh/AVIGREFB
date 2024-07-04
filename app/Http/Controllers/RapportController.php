<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class RapportController extends Controller
{
    public function index()
    {
        $partnaires = DB::table('users')->where('type', 'Partenaire')->get();
        $rapports = DB::table('rapports')->get();
        return view('pages.rapports', compact('rapports'));
    }

    public function create()
    {
        return view('rapports.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'intitule' => 'required|string|max:255',
            'description' => 'required|string',
            'fichier_pdf' => 'required|file|mimes:pdf|max:2048',
        ]);

        $rapport = $request->file('fichier_pdf');
        $rapportname = time().'.'.$rapport->getClientOriginalExtension();
        $path = $rapport->storeAs('rapports', $rapportname, 'public');

        DB::table('rapports')->insert([
            'intitule' => $request->input('intitule'),
            'description' => $request->input('description'),
            'fichier_pdf' => $path,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('rapports.index')->with('success', 'Rapport créé avec succès.');
    }


    public function edit($id)
    {
        $rapport = DB::table('rapports')->where('id', $id)->first();
        return view('rapports.edit', compact('rapport'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'intitule' => 'required|string|max:255',
            'description' => 'required|string',
            'fichier_pdf' => 'file|mimes:pdf|max:2048',
        ]);

        $data = [
            'intitule' => $request->input('intitule'),
            'description' => $request->input('description'),
            'updated_at' => now(),
        ];

        if ($request->hasFile('fichier_pdf')) {
            $path = $request->file('fichier_pdf')->store('rapports');
            $data['fichier_pdf'] = $path;
        }

        DB::table('rapports')->where('id', $id)->update($data);

        return redirect()->route('rapports.index')->with('success', 'Rapport mis à jour avec succès.');
    }

    public function destroy($id)
    {
        $rapport = DB::table('rapports')->where('id', $id)->first();
        if ($rapport) {
            Storage::delete($rapport->fichier_pdf);
            DB::table('rapports')->where('id', $id)->delete();
        }

        return redirect()->route('rapports.index')->with('success', 'Rapport supprimé avec succès.');
    }
}
