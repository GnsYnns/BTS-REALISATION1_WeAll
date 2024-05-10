<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\user;
use App\Models\Post_message;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Like;

class LikeController extends Controller
{
    public function like(Request $request, Post_message $post_message)
    {
        // Vérifiez si l'utilisateur est authentifié
        if (Auth::check()) {
            // Obtenez l'ID de l'utilisateur authentifié
            $userId = Auth::id();

            // Vérifiez si un "like" existe pour l'utilisateur et le message spécifiés
            $existingLike = Like::where('user_id', $userId)
            ->where('post_message_id', $post_message->id)
            ->exists();

            if ($existingLike) {
                // Supprimez le "like" existant
                Like::where('user_id', $userId)
                ->where('post_message_id', $post_message->id)
                ->delete();
                $post_message->decrement('nb_like');
                $post_message->save();
            } else {
                // Si aucun "like" n'existe, créez-en un nouveau
                $post_message->increment('nb_like');
                $post_message->save();

                // Enregistrez le "like" dans la table de "likes"
                Like::create([
                'user_id' => $userId,
                'post_message_id' => $post_message->id,
                ]);
            }

            // Retournez une réponse réussie
            return response()->json(['success' => true]);
        }

        // Retournez une réponse d'échec si l'utilisateur n'est pas authentifié
        return response()->json(['success' => false], 401);
    }

    public function hasUserLikedPost($postId)
    {
        $userId = Auth::id();
        $hasLiked = Like::where('user_id', $userId)->where('post_message_id', $postId)->exists();

        return response()->json(['hasLiked' => $hasLiked]);
    }
}
