<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Auth\Events\Registered;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        DB::beginTransaction();

        try {
            Log::info('Début de l\'enregistrement de l\'utilisateur : ' . $request->email);

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            Log::info('Utilisateur inséré : ', $user->toArray());

            $role = Role::where('name', 'client')->first();
            if ($role) {
                $user->assignRole($role);
                Log::info('Rôle assigné : client');
            } else {
                Log::error('Rôle client introuvable');
                DB::rollback();
                return redirect()->back()->withErrors(['error' => 'Erreur lors de l\'inscription. Veuillez réessayer.'])->withInput();
            }

            DB::commit();

            Log::info('Utilisateur enregistré avec succès');

            // Connecter l'utilisateur après l'inscription
            Auth::login($user);

            // Rediriger vers la page d'accueil ou le catalogue
            return redirect()->route('client.catalog')->with('success', 'Inscription réussie ! Bienvenue sur ISI BURGER.');

        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Erreur lors de l\'enregistrement : ' . $e->getMessage());

            return redirect()->back()->withErrors(['error' => 'Erreur lors de l\'inscription. Veuillez réessayer.'])->withInput();
        }
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Redirection selon le rôle
            if (Auth::user()->hasRole('gestionnaire')) {
                return redirect()->route('gestionnaire.dashboard')->with('success', 'Connexion réussie! Bienvenue dans votre tableau de bord.');
            }

            return redirect()->route('client.catalog')->with('success', 'Connexion réussie! Bienvenue sur ISI BURGER.');
        }

        return back()->withErrors([
            'email' => 'Les identifiants fournis ne correspondent pas à nos enregistrements.',
        ])->withInput();
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('success', 'Vous avez été déconnecté avec succès.');
    }
}
