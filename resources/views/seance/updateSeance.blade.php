@extends('layout')
@section('title', $title)
@section('content')

	<div class="blockTitle">
		<h2 class="mainTitle">Modifier la séance</h2>
		<a title="Revenir à la séance" class="backButton blockTitle__backButton unlink mainColorfont" href="{!! action( 'SeanceController@view', [ 'id' => $id ] ) !!}"><span class="hidden">Revenir à la page précédente</span><span class="icon-arrow-left"></span></a>
	</div>


	<div class="box--group">
		<div class="box box--shadow">
			<form class="box__group--content" action="" method="post">
				@include( 'errors.profilError' )

				<div class="form-group">
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
					<label class="color_label" for="course">Pour le cours de…</label>
					<select class="form-control" name="course" id="course">
						@foreach( $courses as $course )
							<option @if($course->id == $course_id)selected="selected" @endif value="{{ $course->id }}">{{ $course->title }}</option>
						@endforeach
					</select>
				</div>

				<div class="form-group">
					<label class="color_label" for="datepicker_start">Pour quel jour?</label>
					<input type="date" class="form-control" name="date" id="datepicker_start" value="{{ $start_day }}">
				</div>

				<div class="form-group">
					<label class="color_label" for="start_hours">Heure de début</label>
					<input type="time" class="start_hours" name="start_hours" id="start_hours" value="{{ $start_hours }}" data-field="time" data-startend="start" data-format="hh:mm" data-startendelem=".end_hours">
				</div>

				<div class="form-group">
					<label class="color_label" for="end_hours">Heure de fin</label>
					<input type="time" class="end_hours" name="end_hours" id="end_hours" value="{{ $end_hours }}" data-field="time" data-format="hh:mm" data-startend="end" data-startendelem=".start_hours">
				</div>

				<div class="form-group">
					<label class="color_label" for="local">Le local</label>
					<input type="text" name="local" id="local" @if( $local == null )placeholder="Aucun pour le moment" @else value="{{ $local }}" @endif>
				</div>

				<div class="form-group--button text-center">
					<input type="submit" class="btn btn-send" value="Valider les modifications">
					<div class="clear"></div>
				</div>

				<div id="dtBox"></div>

			</form>
		</div>
	</div>

@endsection