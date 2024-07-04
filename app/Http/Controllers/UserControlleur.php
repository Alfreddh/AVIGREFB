<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Notifications\UserCredentials;
use Illuminate\Support\Facades\Notification;
use Egulias\EmailValidator\EmailValidator;
use Egulias\EmailValidator\Validation\RFCValidation;

class UserControlleur extends Controller
{
    public function index()
    {
        $users = DB::table('users')->get();
        return view('pages.laravel-examples.user-management', compact('users'));
    }

    public function create()
    {
        return view('laravel-examples.user-create');
    }

    public function store(Request $request)
    {
       
        $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'type' => 'nullable',
        ]);
        
        $validator = new EmailValidator();
        if (!$validator->isValid($request->input('email'), new RFCValidation())) {
            return redirect()->back()->withInput()->withErrors(['email' => 'Adresse email non valide.']);
        }
        
        $password = $request->input('name') . '@avigref';
        
        DB::table('users')->insert([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'type' => $request->input('type'),
            'password' => Hash::make($password),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        Notification::route('mail', $request->input('email'))->notify(new UserCredentials($request->input('email'), $password));
        return redirect()->route('users.index')->with('success', 'Utilisateur créé avec succès.');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('laravel-examples.user-edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'nullable|string|max:255',
            'email' => 'nullable|string|email|max:255|unique:users,email,' . $id,
            'type' => 'nullable|string',
            'password' => 'nullable|string|min:8',
            'location' => 'nullable',
            'phone' => 'nullable',

        ]);

        $updateData = [
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'type' => $request->input('type'),
            'phone' => $request->input('phone'),
        ];

        if ($request->filled('password')) {
            $updateData['password'] = Hash::make($request->input('password'));
        }

        DB::table('users')->where('id', $id)->update($updateData);

        return redirect()->route('users.index')->with('success', 'Utilisateur mis à jour avec succès.');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('users.index')->with('success', 'Utilisateur supprimé avec succès.');
    }
}
