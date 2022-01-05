@extends('layout')
@section('title', $title)
@section('content')

	<div class="blockTitle">
		<h2 class="mainTitle">Changer ma photo</h2>

		<a title="Revenir à la page de profil" class="backButton blockTitle__backButton unlink mainColorfont" href="{!! action( 'PageController@about' ) !!}"><span class="hidden">Revenir à la page précédente</span><span class="icon-arrow-left"></span></a>
	</div>

	<div class="box--group">
		<!-- Profil photo -->
		<div class="box_profilPicture box__profilImage box__profilImage--profilPage box__profilImage--profilPage--change">
			<img class="box__profilImage" src="{{ url() }}/img/profilPicture/{{ Auth::user()->image }}" alt="Image de profil">
		</div>

		<!-- id information -->
		<div class="box box--shadow box_profil--picture">
			<form class="box__group--content" action="" method="post" enctype="multipart/form-data">
				@include('errors.profilError')

				<div class="form-group">
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
					<label class="color_label" for="image">Changer l’image</label>
					<input type="file" class="form-control action__changePicture" name="image" id="image">
				</div>

				<div class="form-group--button">
					<input type="submit" class="btn btn-send" value="Valider les modifications">
					<div class="clear"></div>
				</div>

			</form>
		</div>
	</div>
@endsection