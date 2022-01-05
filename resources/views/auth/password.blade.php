@section('title', 'Mot de passe oublié • ISEP')
@include( 'header' )
<body class="default">

<!-- resources/views/auth/password.blade.php -->
<div class="blockTitle">
    <h2 class="mainTitle">Mot de passe oublié</h2>
    <a title="Revenir à la page précédente" class="backButton blockTitle__backButton unlink mainColorfont" href="{!! action( 'Auth\AuthController@getLogin' ) !!}"><span class="hidden">Revenir à la page précédente</span><span class="icon-arrow-left"></span></a>
</div>


<div class="box--group">
    <div class="box box--shadow box__connect--page">
        @if ( session('status') )
            <div class="box__group--content box__passwordResetSuccess">
                <div class="icon icon-envelope-letter"></div>
                <p class="box__passwordResetSuccess_message">{{ session('status') }}</p>
            </div>
        @else
            <form class="box__group--content" method="POST" action="/password/email">
                @include('errors.profilError')
                {!! csrf_field() !!}

                <div class="form-group form-information form-information--password">
                    <p><span class="icon-info icon mainColorfont"></span> En complétant ce formulaire, vous allez recevoir un email afin de pouvoir changer votre mot de passe.</p>
                </div>

                <div class="form-group">
                    <label class="color_label" for="email">Email</label>
                    <input class="form-control" type="email" name="email" id="email" value="{{ old('email') }}" autofocus>
                </div>

                <div class="form-group--button">
                    <button class="btn btn-send" type="submit">Envoyez un lien par email</button>
                    <div class="clear"></div>
                </div>

            </form>
        @endif
    </div>
</div>

@include( 'footer' )
