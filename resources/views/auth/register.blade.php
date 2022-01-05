@section('title', 'Inscription • ISEP')
@include( 'header' )
<body class="home default">

    <div class="blockTitle">
        <h2 class="mainTitle">Inscription</h2>
        <a title="Revenir à la page d’accueil" class="backButton blockTitle__backButton unlink mainColorfont" href="{!! route( 'home' ) !!}"><span class="hidden">Revenir à la page précédente</span><span class="icon-arrow-left"></span></a>
    </div>

    <div class="box--group">
        <div class="box box--shadow box__connect--page">
            <form class="box__group--content" method="POST" action="/register">
                @include('errors.profilError')
                {!! csrf_field() !!}

                <div class="form-group">
                    <label class="color_label" for="firstname">Prénom</label>
                    <input class="form-control" type="text" name="firstname" id="firstname" value="{{ old('firstname') }}" autofocus>
                </div>

                <div class="form-group">
                    <label class="color_label" for="name">Nom</label>
                    <input class="form-control" type="text" name="name" id="name" value="{{ old('name') }}">
                </div>

                <div class="form-group">
                    <label class="color_label" for="email">Email</label>
                    <input class="form-control" type="email" name="email" id="email" value="{{ old('email') }}">
                </div>

                <div class="form-group">
                    <label class="color_label" for="password">Mot de passe</label>
                    <input class="form-control" type="password" name="password" id="password">
                </div>

                <div class="form-group">
                    <label class="color_label" for="password_confirmation">Confirmation du mot de passe</label>
                    <input class="form-control" type="password" name="password_confirmation" id="password_confirmation">
                </div>

                <div class="form-group radio__typeUser">
                    <p>Vous êtes un…</p>
                    <div class="form-group__content">
                        <input class="hidden form-control" type="radio" name="status" id="teacher" value="1">
                        <label for="teacher">professeur</label>

                        <input class="hidden form-control" type="radio" name="status" id="student" value="2">
                        <label for="student">étudiant</label>
                        <div class="clear"></div>
                    </div>
                </div>

                <div class="form-group--button">
                    <p class="connextSwitchBtn">J'ai déjà un compte&nbsp;? <a href="{{ action( 'Auth\AuthController@getLogin' ) }}">Connectez-vous</a></p>
                    <button class="btn btn-send" type="submit">S'inscrire</button>
                    <div class="clear"></div>
                </div>

            </form>
        </div>
    </div>

@include( 'footer' )
