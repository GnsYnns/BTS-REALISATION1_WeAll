<?php

namespace App\Http\Controllers;
use App\Models\user;
use App\Models\Post_message;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Like;


class PostController extends Controller
{
    public function index(Request $request)
    {
        $query = Post_message::with('user') // Chargement eager des données utilisateur
            ->whereNull('id_referencecomment')
            ->join('users', 'post_message.id_users', '=', 'users.id') // Joindre la table users
            ->select('post_message.*', 'users.name as name'); // Sélectionner les colonnes nécessaires

        // Appliquer le filtrage par nom si un paramètre 'search' est présent
        if ($request->has('search')) {
            $query->where('users.name', 'like', '%'. $request->search. '%');
        }

        // Appliquer le tri basé sur le paramètre 'sort'
        switch ($request->sort) {
            case 'name_asc':
                $query->orderBy('users.name', 'asc');
                break;
            case 'name_desc':
                $query->orderBy('users.name', 'desc');
                break;
            case 'comments_asc':
                $query->orderBy('nombre_commentaires', 'asc');
                break;
            case 'comments_desc':
                $query->orderBy('nombre_commentaires', 'desc');
                break;
            case 'date_asc':
                $query->orderBy('created_at', 'asc');
                break;
            case 'date_desc':
                $query->orderBy('created_at', 'desc');
                break;
            default:
                $query->orderBy('created_at', 'desc'); // Tri par défaut
        }

        $messages = $query->paginate(5); // Pagination

        return view('dashboard', compact('messages'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Vérifiez si l'utilisateur est authentifié
        if (Auth::check()) {
            // Obtenez l'ID de l'utilisateur authentifié
            $idUtilisateur = Auth::id();

            // Créez un nouvel enregistrement avec l'ID de l'utilisateur
            $message = new Post_message;
            $message->id_users = $idUtilisateur;
            $message->id_referencecomment = $request->input('id');
            $message->text = $request->input('content');
                
            // Si le message est une réponse à un autre message, incrémentez le nombre de commentaires
            if ($message->id_referencecomment!== null) {
                // Trouvez le message original et incrémentez son nombre de commentaires
                $originalMessage = Post_message::find($message->id_referencecomment);
                if ($originalMessage) {
                    $originalMessage->increment('nb_comment'); // Assurez-vous que cette colonne existe dans votre table
                }
            }
            // Enregistrez le message dans la base de données
            $message->save();

            $messages = Post_message::with('user') // Chargement eager des données utilisateur
            ->whereNull('id_referencecomment')
            ->orderBy('created_at', 'desc')
            ->paginate(5); // Pagination (personnalisez selon vos besoins)

            return redirect()->route('dashboard')->with('success', 'Votre message a été envoyé avec succès.');
        } else {
            // Gérez le cas où l'utilisateur n'est pas authentifié
            // Par exemple, redirigez l'utilisateur vers la page de connexion
            return redirect()->route('login')->with('error', 'Veuillez vous connecter pour envoyer un message');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Post_message $post_message)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post_message $post_message)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post_message $post_message)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post_message $post_message)
    {
        //
    }
    
    public function showDashboard()
    {
        // Récupérez les messages depuis la base de données
        $messages = Post_message::all();

        // Retournez la vue avec les messages
        return view('dashboard', compact('messages'));
    }
}
