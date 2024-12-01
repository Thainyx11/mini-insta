<?php

namespace App\Http\Controllers;

use App\Models\Publication;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;


class PublicationController extends Controller
{
    public function index()
    {
        $publications = Publication::with('user', 'likes', 'comments')->latest()->get();
        return view('publication.feed', compact('publications'));
    }

    public function create()
    {
        return view('publication.create-publication');
    }

    public function store(Request $request)
    {
        // Valider les données reçues
        $request->validate([
            'caption' => 'required|string|max:255',
            'image' => 'required|image|max:5120', // Limite de taille en Ko
        ]);

        // Vérifier que le fichier a bien été reçu
        if ($request->hasFile('image')) {
            // Générer un nom de fichier unique basé sur le timestamp
            $fileName = time() . '_' . $request->file('image')->getClientOriginalName();

            // Stocker le fichier dans le dossier `storage/app/public/images`
            $path = $request->file('image')->storeAs('images', $fileName, 'public');

            // Enregistrer la publication dans la base de données avec le chemin de l'image
            auth()->user()->publications()->create([
                'caption' => $request->caption,
                'image_url' => $path,
            ]);

            // Rediriger vers le feed avec un message de succès
            return redirect()->route('feed')->with('success', 'Publication ajoutée avec succès !');
        }

        // En cas d'échec du téléchargement
        return redirect()->back()->withErrors(['image' => 'Échec du téléchargement de l\'image.']);
    }



    public function show($id)
    {
        $publication = Publication::with('user', 'comments', 'likes')->findOrFail($id);
        return view('publication.publication-detail', compact('publication'));
    }

    public function destroy($id)
    {
        $publication = Publication::findOrFail($id);

        // Vérifie si l'utilisateur est bien le propriétaire de la publication
        if ($publication->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $publication->delete();
        return redirect()->route('feed')->with('success', 'Publication supprimée.');
    }
}
