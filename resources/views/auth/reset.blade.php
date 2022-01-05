@section('title', 'Changer le mot de passe • ISEP')
@include( 'header' )
<body class="default">
<!-- resources/views/auth/reset.blade.php -->

<div class="blockTitle">
    <h2 class="mainTitle">Changer le mot de passe</h2>
</div>

<div class="box--group">
    <div class="box box--shadow box__connect--page">
        <form class="box__group--content" method="POST" action="/password/reset">
            @include('errors.profilError')
            {!! csrf_field() !!}

            <input type="hidden" name="token" value="{{ $token }}">

            <div class="form-group">
                <label class="color_label" for="email">Email</label>
                <input class="form-control" type="email" name="email" id="email" value="{{ old('email') }}" autofocus>
            </div>

            <div class="form-group">
                <label class="color_label" for="password">Mot de passe</label>
                <input class="form-control" type="password" name="password" id="password">
            </div>

            <div class="form-group">
                <label class="color_label" for="password_confirmation">Confirmation mot de passe</label>
                <input class="form-control" type="password" name="password_confirmation" id="password_confirmation">
            </div>

            <div class="form-group--button">
                <button class="btn btn-send" type="submit">Modifier le mot de passe</button>
                <div class="clear"></div>
            </div>

        </form>

@include( 'footer' )
