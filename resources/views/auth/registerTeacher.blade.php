@extends('logoutLayout')
@section('title', 'Inscription professeur • ISEP')
@section('content')
    <div class="blockTitle">
        <h2 class="mainTitle">{{ $title }}</h2>
    </div>

    <div class="spaceContainer">
        <div class="littleSpace">

            <form method="POST" action="/auth/register">
                @include('errors.profilError')
                {!! csrf_field() !!}

                <div class="form-group regirsterForm__group">
                    <label for="firstname">Prénom</label>
                    <input type="text" name="firstname" id="firstname" value="{{ old('firstname') }}">
                </div>

                <div class="form-group regirsterForm__group">
                    <label for="name">Nom</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}">
                        <!-- old()  => est une variable temporaire qui récupère (le temps d'une requete) les information SANS le mot de passe histoire d’éviter de devoir TOUT retapper. -->
                </div>

                <div class="form-group regirsterForm__group">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}">
                </div>

                <div class="form-group regirsterForm__group">
                    <label for="password">Mot de passe</label>
                    <input type="password" name="password" id="password">
                </div>

                <div class="form-group regirsterForm__group">
                    <label for="password_confirmation">Confirmation du mot de passe</label>
                    <input type="password" name="password_confirmation" id="password_confirmation">
                </div>

                <div class="form-group regirsterForm__group">
                	<input type="hidden" name="status" id="teacher" value="1">
                    <a href="{{ action( 'CourseController@index' ) }}" class="btn btn-back">Retour</a>
                    <button class="btn btn-send" type="submit">S'enregistrer</button>
                    <div class="clear"></div>
                </div>

            </form>
        </div>
    </div>

@stop