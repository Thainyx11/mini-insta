<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Publication;
use App\Models\CommentLike;
use App\Models\PubliLike;

class LikeController extends Controller
{
    public function likeComment($commentId)
    {
        $comment = Comment::findOrFail($commentId);
        if (!$comment->likes()->where('user_id', auth()->id())->exists()) {
            // Crée le like pour le commentaire
            CommentLike::create([
                'user_id' => auth()->id(),
                'comment_id' => $commentId,
            ]);

            // Crée une notification pour le propriétaire du commentaire
            $comment->user->notifications()->create([
                'message' => auth()->user()->name . ' a liké votre commentaire.',
                'is_read' => false,
            ]);
        }
        return redirect()->back();
    }

    public function likePublication($publicationId)
    {
        $publication = Publication::findOrFail($publicationId);
        if (!$publication->likes()->where('user_id', auth()->id())->exists()) {
            // Crée le like pour la publication
            PubliLike::create([
                'user_id' => auth()->id(),
                'publication_id' => $publicationId,
            ]);

            // Crée une notification pour le propriétaire de la publication
            $publication->user->notifications()->create([
                'message' => auth()->user()->name . ' a liké votre publication.',
                'is_read' => false,
            ]);
        }
        return redirect()->back();
    }



    public function unlikeComment($commentId)
    {
        CommentLike::where('comment_id', $commentId)->where('user_id', auth()->id())->delete();
        return redirect()->back();
    }

    public function unlikePublication($publicationId)
    {
        PubliLike::where('publication_id', $publicationId)->where('user_id', auth()->id())->delete();
        return redirect()->back();
    }

}
