@extends('layout')
@section('title', $title)
@section('content')

	<div class="blockTitle">
		<h2 class="mainTitle">Modifier mon profil</h2>
		<a title="Revenir à la page de profil" class="backButton blockTitle__backButton unlink mainColorfont" href="{!! action( 'PageController@about' ) !!}"><span class="hidden">Revenir à la page précédente</span><span class="icon-arrow-left"></span></a>
	</div>

	<div class="box--group">
		<div class="box box--shadow">
			<form class="box__group--content" action="" method="post">
				@include('errors.profilError')

				<div class="form-group">
					<label class="color_label" for="firstname">Votre prénom</label>
					<input type="text" class="form-control" name="firstname" id="firstname" placeholder="ex: Mathématiques" value="{{ $firstname }}" autofocus>
				</div>

				<div class="form-group">
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
					<label class="color_label" for="name">Votre nom</label>
					<input type="text" class="form-control" name="name" id="name" placeholder="ex: Mathématiques" value="{{ $name }}">
				</div>

				<div class="form-group">
					<label class="color_label" for="email">Votre email</label>
					<input type="text" class="form-control" name="email" id="email" placeholder="ex: 3e gestion" value="{{ $email }}">
				</div>

				<div class="form-group">
					<a class="ChangePasswordLink unlink" href="{{ action( 'PageController@updatePassword' ) }}">
						<span class="icon-lock icon"></span>
						<span>Changer le mot de passe</span>
					</a>
				</div>

				<div class="form-group--button">
					<input type="submit" class="btn btn-send" value="Valider les modifications">
					<div class="clear"></div>
				</div>

			</form>
		</div>
	</div>


@endsection