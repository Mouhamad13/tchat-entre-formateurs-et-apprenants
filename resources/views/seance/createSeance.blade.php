@extends('layout')
@section('title', $title)
@section('content')

	<div class="blockTitle">
		<h2 class="mainTitle">Créer de nouvelles séances</h2>
		<a title="Revenir au cours" class="backButton blockTitle__backButton unlink mainColorfont" href="{!! action( 'CourseController@view', [ 'id' => $id ] ) !!}"><span class="hidden">Revenir à la page précédente</span><span class="icon-arrow-left"></span></a>
	</div>

	<div class="box--group">
		<div class="box box--shadow">
			<form class="box__group--content" action="" method="post">
				@include( 'errors.profilError' )

				<div class="form-group">
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
					<input type="hidden" name="course" value="{{ $id }}">
				</div>

				<div class="form-group">
					<label class="color_label" for="daypicker">Pour quel jour</label>
					<select name="daypicker" id="daypicker">
						<span class="icon-arrow-left"></span>
						@foreach ($days as $day => $jour)
							<option value="{{ $day }}">{{ $jour }}</option>
						@endforeach
					</select>
				</div>

				<div class="form-group">
					<label class="color_label" for="datepicker_start">Début de période</label>
					<input type="date" class="start_date" name="start_date" id="datepicker_start" data-field="date" data-startend="start" data-startendelem=".end_date" value="{{ $today }}">
				</div>

				<div class="form-group">
					<label class="color_label" for="datepicker_end">Fin de période</label>
					<input type="date" class="end_date" name="end_date" id="datepicker_end" data-field="date" data-startend="end" data-startendelem=".start_date" placeholder="{{ $tomorrow }}">
				</div>

				<div class="form-group">
					<label class="color_label" for="start_hours">Heure de début</label>
					<input type="time" class="start_hours" name="start_hours" id="start_hours" value="08:00" data-field="time" data-startend="start" data-format="hh:mm" data-startendelem=".end_hours">
				</div>

				<div class="form-group">
					<label class="color_label" for="end_hours">Heure de fin</label>
					<input type="time" class="end_hours" name="end_hours" id="end_hours" placeholder="10:00" data-field="time" data-format="hh:mm" data-startend="end" data-startendelem=".start_hours">
				</div>

				<div class="form-group">
					<label class="color_label" for="local">Le local</label>
					<input type="text" name="local" id="local" placeholder="Labo chimie">
				</div>

				<div class="form-group--button text-center">
					<input type="submit" class="btn btn-send" value="Générer les séances">
					<div class="clear"></div>
				</div>

				<div id="dtBox"></div>

			</form>
		</div>
	</div>

@endsection