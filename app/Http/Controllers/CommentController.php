<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Publication;
use App\Models\Notification;

class CommentController extends Controller
{
    public function store(Request $request, $publicationId)
    {
        $request->validate([
            'content' => 'required|string|max:500',
        ]);

        $publication = Publication::findOrFail($publicationId);
        $comment = $publication->comments()->create([
            'user_id' => auth()->id(),
            'content' => $request->content,
        ]);

        // Créez une notification pour le propriétaire de la publication
        if ($publication->user_id !== auth()->id()) {
            $publication->user->notifications()->create([
                'message' => auth()->user()->name . ' a commenté votre publication.',
                'is_read' => false,
            ]);
        }

        return redirect()->back();
    }

    public function destroy($id)
    {
        $comment = Comment::findOrFail($id);

        // Vérifie si l'utilisateur est le propriétaire du commentaire ou de la publication associée
        if ($comment->user_id !== auth()->id() && $comment->publication->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $comment->delete();
        return redirect()->back()->with('success', 'Commentaire supprimé.');
    }
}
