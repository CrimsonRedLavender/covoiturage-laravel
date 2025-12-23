@extends('layouts.app')

@section('content')
    <h1>Covoiturage : connectez-vous</h1>
    <form action='index.php' method='post'>
        <h1>Connexion</h1>

        <label><b>Compte</b></label>
        <input type='text' name='identifiant' required>
        <br>
        <label><b>Mot de passe</b></label>
        <input type='password' name='mdp' required>
        <br>
        <button type='submit' id='submit' name='action' value='Se connecter' >Se connecter</button>
        <br>
    </form>
    <li><a href='/signin/register'>S'inscrire</a></li>
@endsection
