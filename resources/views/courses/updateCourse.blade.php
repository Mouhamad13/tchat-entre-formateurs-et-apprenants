@extends('layout')
@section('title', $pageTitle)
@section('content')
	<div class="blockTitle">
		<h2 class="mainTitle">Modifier le cours</h2>
		<a title="Revenir au cours" class="backButton blockTitle__backButton unlink mainColorfont" href="{!! action( 'CourseController@view', [ 'id' => $id ] ) !!}"><span class="hidden">Revenir à la page précédente</span><span class="icon-arrow-left"></span></a>
	</div>


	<div class="box--group">
		<div class="box box--shadow">
			<form class="box__group--content" action="" method="post">
				@include('errors.profilError')

				<div class="form-group">
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
					<label class="color_label" for="title">Ajouter le titre du cours</label>
					<input type="text" class="form-control" name="title" id="title" placeholder="ex: Mathématiques" value="{{ $title }}">
				</div>

				<div class="form-group">
					<label class="color_label" for="group">Ajouter le nom du groupe</label>
					<input type="text" class="form-control" name="group" id="group" placeholder="ex: 3e gestion" value="{{ $group }}">
				</div>

				<div class="form-group">
					<label class="color_label" for="school">Ajouter le nom de l'établissement scolaire</label>
					<input type="text" class="form-control" name="school" id="school" placeholder="ex: Saint-luc" value="{{ $school }}">
				</div>

				<div class="form-group">
					<label class="color_label" for="place">Ajouter le nom de la ville où se trouve cette école</label>
					<input type="text" class="form-control" name="place" id="place" placeholder="ex: Liège" value="{{ $place }}">
				</div>

				<div>
					<input type="submit" class="btn btn-send" value="Valider les modifications">
					<div class="clear"></div>
				</div>

			</form>
		</div>
	</div>


@endsection