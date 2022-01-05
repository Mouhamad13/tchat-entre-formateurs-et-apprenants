@section('title', 'Connexion • ISEP')
@include( 'header' )
<body class="home default">

    <div class="blockTitle">
        <h2 class="mainTitle">Connexion</h2>
        <a title="Revenir à la page d’accueil" class="backButton blockTitle__backButton unlink mainColorfont" href="{!! route( 'home' ) !!}"><span class="hidden">Revenir à la page précédente</span><span class="icon-arrow-left"></span></a>
    </div>

    <div class="box--group">
        <div class="box box--shadow box__connect--page">
            <form class="box__group--content" method="POST" action="/login">
                @include('errors.profilError')
                {!! csrf_field() !!}

                <div class="form-group">
                    <label class="color_label" for="email">Email</label>
                    <input class="form-control" type="email" name="email" id="email" value="{{ old('email') }}" autofocus>
                </div>

                <div class="form-group">
                    <label class="color_label" for="password">Mot de passe</label>
                    <input class="form-control" type="password" name="password" id="password">
                </div>

                <div class="form-group">
                    <input class="form__remember" type="checkbox" checked id="remember" name="remember"> <label for="remember">Se souvenir de moi</label>

                    <a class="unlink forgetPassword" href="{{ action( 'Auth\PasswordController@getEmail' ) }}">J'ai oublié mon mot de passe</a>
                </div>

                <div class="form-group--button">
                    <p class="connextSwitchBtn">Pas encore de compte&nbsp;? <a href="{{ action( 'Auth\AuthController@getRegister' ) }}">Inscrivez-vous</a></p>
                    <button class="btn btn-send" type="submit">Se connecter</button>
                    <div class="clear"></div>
                </div>

            </form>
        </div>
    </div>

@include( 'footer' )
