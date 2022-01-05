@extends('layout')
@section('title', $title)
@section('content')

    <div class="blockTitle">
        <h2 class="mainTitle">Modifier mon mot de passe</h2>

        <a title="Revenir à la page de modification de profil" class="backButton blockTitle__backButton unlink mainColorfont" href="{!! action( 'PageController@editProfil' ) !!}"><span class="hidden">Revenir à la page précédente</span><span class="icon-arrow-left"></span></a>
    </div>

    <div class="box--group">
        <div class="box box--shadow">
            <form class="box__group--content" action="" method="post">
                @include('errors.profilError')

                <div class="form-group">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <label class="color_label" for="password">Votre nouveau mot de passe</label>
                    <input type="password" class="form-control" name="password" id="password" autofocus>
                </div>

                <div class="form-group">
                    <label class="color_label" for="password_confirmation">Valider le mot de passe</label>
                    <input type="password" class="form-control" name="password_confirmation" id="password_confirmation">
                </div>

                <div class="form-group--button">
                    <input type="submit" class="btn btn-send" value="Valider les modifications">
                    <div class="clear"></div>
                </div>

            </form>
        </div>
    </div>


@endsection