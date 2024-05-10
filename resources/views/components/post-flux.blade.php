<link href="https://fonts.googleapis.com/css?family=Asap" rel="stylesheet">

<style>
    body {
        font-family: 'Asap', sans-serif;
    }
    
    #commentDiv{{$id}} {
        display: none;
    }

    #addCommentDiv{{$id}} {
        display: none;
    }

    img {
        max-width: 100%;
    }

    .avator {
        border-radius: 100px;
        width: 48px;
        margin-right: 15px;
    }


    .tweet-wrap {
        max-width: 490px;
        background: #fff;
        margin: 0 auto;
        margin-top: 50px;
        border-radius: 3px;
        padding: 30px;
        border-bottom: 1px solid #e6ecf0;
        border-top: 1px solid #e6ecf0;
    }

    .tweet-header {
        display: flex;
        align-items: flex-start;
        font-size: 14px;
    }

    .tweet-header-info {
        font-weight: bold;
    }

    .tweet-header-info span {
        color: #000000;
        font-weight: normal;
        margin-left: 5px;
    }

    .tweet-header-info p {
        font-weight: normal;
        margin-top: 5px;

    }

    .tweet-img-wrap {
        padding-left: 60px;
    }

    .tweet-info-counts {
        display: flex;
        margin-left: 60px;
        margin-top: 10px;
    }

    .tweet-info-counts div {
        display: flex;
        margin-right: 20px;
    }

    .tweet-info-counts div svg {
        margin-right: 10px;
    }

    @media screen and (max-width:430px) {
        body {
            padding-left: 20px;
            padding-right: 20px;
        }

        .tweet-header {
            flex-direction: column;
        }

        .tweet-header img {
            margin-bottom: 20px;
        }

        .tweet-header-info p {
            margin-bottom: 30px;
        }

        .tweet-img-wrap {
            padding-left: 0;
        }

        .tweet-info-counts {
            display: flex;
            margin-left: 0;
        }

        .tweet-info-counts div {
            margin-right: 10px;
        }
    }
</style>
<div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg m-1">
    <div class="p-6 text-gray-900 dark:text-gray-100">
        <div class="tweet-header">
            <img src="https://soccerpointeclaire.com/wp-content/uploads/2021/06/default-profile-pic-e1513291410505.jpg"
                alt="" class="avator">
            <div class="tweet-header-info">
                {{$name}} - écrit le {{$date}}
                <p>{{$text}}</p>

            </div>

        </div>
        <div class="tweet-info-counts">

            <div class="comments">
                <svg class="hover:fill-black dark:hover:fill-white feather feather-message-circle sc-dnqmqq jxshSx" xmlns="http://www.w3.org/2000/svg"
                    width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" onclick="afficherComment({{$id}})">
                    <path
                        d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z">
                    </path>
                </svg>
                <div class="comment-count">{{$comment}}</div>
            </div>

            <div class="likes" data-message-id="{{$id}}">
                <svg id="like-icon{{$id}}" class="hover:fill-black dark:hover:fill-white feather feather-heart sc-dnqmqq jxshSx" xmlns="http://www.w3.org/2000/svg" width="20"
                    height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path
                        d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z">
                    </path>
                </svg>
                <div class="likes-count">
                    {{$like}}
                </div>
            </div>

            <div class="message">
                <svg class="hover:fill-black dark:hover:fill-white feather feather-send sc-dnqmqq jxshSx" xmlns="http://www.w3.org/2000/svg" width="20"
                    height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" onclick="afficherAddComment({{$id}})"
                    stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m4.988 19.012 5.41-5.41m2.366-6.424 4.058 4.058-2.03 5.41L5.3 20 4 18.701l3.355-9.494 5.41-2.029Zm4.626 4.625L12.197 6.61 14.807 4 20 9.194l-2.61 2.61Z"/>
                </svg>
            </div>
        </div>
        <div id="commentDiv{{$id}}">
            @php
            //$messages = App\Models\Message::take(2)->get();
            $comments = App\Models\Post_message::where('id_referencecomment',$id)->get();
            @endphp
            @for ($i = 0; $i < count($comments); $i++) <!-- individual listings -->
                @php
                $postcomment = $comments[$i];
                $nom = App\Models\User::find($postcomment->id_users)->name;
                @endphp
                <x-post-flux :name='$nom' :text='$postcomment->text' :like='$postcomment->nb_like' :retweet='$postcomment->nb_retweet'
                    :date='$postcomment->created_at->format("d/m/Y")' :comment='$postcomment->nb_comment' :id='$postcomment->id' />
                @endfor
        </div>
        <div id="addCommentDiv{{$id}}">
            <x-create-post :id='$id'/>
        </div>
        
        <script>
            $(document).ready(function() {
                // Vérifiez si l'utilisateur a déjà "liké" le post
                var postId = "{{ $id }}"; // Assurez-vous que $id est correctement défini dans votre vue
                $.ajax({
                    url: '/like/hasUserLikedPost/' + postId, // Ajoutez postId à l'URL
                    type: 'GET',
                    success: function(response) {
                        if (response.hasLiked) {
                            // Changez la couleur de l'SVG en rouge si l'utilisateur a déjà "liké" le post
                            $('#like-icon'+ postId).css('fill', 'red');
                        } else {
                            // Changez la couleur de l'SVG à sa couleur initiale si l'utilisateur n'a pas "liké" le post
                            $('#like-icon' + postId).css('fill', ''); // Ou utilisez la couleur initiale souhaitée
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.error(textStatus, errorThrown);
                    }
                });
            });

        </script>

    </div>
</div>