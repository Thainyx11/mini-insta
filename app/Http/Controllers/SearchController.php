<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Publication;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('query');

        // Recherche d'utilisateurs par nom
        $users = User::where('name', 'LIKE', "%{$query}%")->get();

        // Recherche de publications par légende (caption)
        $publications = Publication::where('caption', 'LIKE', "%{$query}%")->with('user')->get();

        return view('search.results', compact('users', 'publications', 'query'));
    }
}
