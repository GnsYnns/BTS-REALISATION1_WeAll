<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Flux') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form method="GET" action="{{ route('message.index') }}">
                <div class="flex items-center justify-between mb-4">
                    <label for="search" class="mr-2">Rechercher par nom:</label>
                    <input type="text" name="search" id="search" value="{{ request()->get('search') }}" placeholder="Nom d'utilisateur">
            
                    <label for="sort" class="ml-2 mr-2">Trier par:</label>
                    <select name="sort" id="sort">
                        <option value="">Trier par</option>
                        <option value="name_asc">Nom (Croissant)</option>
                        <option value="name_desc">Nom (Décroissant)</option>
                        <option value="comments_asc">Nombre de commentaires (Croissant)</option>
                        <option value="comments_desc">Nombre de commentaires (Décroissant)</option>
                        <option value="date_asc">Date (Croissant)</option>
                        <option value="date_desc">Date (Décroissant)</option>
                    </select>
            
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Rechercher</button>
                </div>
            </form>
            
            <x-create-post :id='NULL'/>
            @if ($messages->isEmpty())
                <p>No messages found.</p>
            @else
                @foreach ($messages as $message)
                @php
                    $name = App\Models\User::find($message->id_users)->name;
                @endphp
                    <x-post-flux :name="$name"
                                :text="$message->text"
                                :like="$message->nb_like"
                                :date="$message->created_at->format('d/m/Y')"
                                :comment="$message->nb_comment"
                                :id="$message->id"/>
                @endforeach
            @endif
            {{ $messages->links() }}
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        // Fonction pour afficher la div
        function afficherComment(id) {
            var div = document.getElementById("commentDiv"+id);
            if (div.style.display === 'none' || div.style.display === '') {
                div.style.display = 'block';
            } else {
                div.style.display = 'none';
            }
        }

        function afficherAddComment(id) {
            var div = document.getElementById("addCommentDiv"+id);
            if (div.style.display === 'none' || div.style.display === '') {
                div.style.display = 'block';
            } else {
                div.style.display = 'none';
            }
        }

        $(document).ready(function() {
            $(".likes").click(function(e) {
                e.preventDefault(); // Empêche le comportement par défaut du lien
                var messageId = $(this).closest('.likes').data('message-id');
                $.ajax({
                    url: '/like/' + messageId + '/like', // URL de la route pour liker un message
                    type: 'POST',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content') // CSRF token pour la sécurité
                    },
                    success: function(response) {
                        // Mettez à jour le compteur de likes ici
                        var likesCountElement = $(this).find('.likes-count');
                        likesCountElement.text(response.newLikesCount); // Supposons que la réponse contient le nouveau nombre de likes
                        location.reload();
                    },
                    error: function(response) {
                        alert('Erreur lors de l\'envoi du like.');
                        console.log(response);
                    }
                });
            });
        });
    </script>
</x-app-layout>
