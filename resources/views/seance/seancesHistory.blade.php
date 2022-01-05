@extends('layout')
@section('title', $title)
@section('content')

	<div class="blockTitle">
		<h2 class="mainTitle">Toutes les séances terminées</h2>
		<a title="Revenir à la liste des séances en cours" class="backButton blockTitle__backButton unlink mainColorfont" href="{!! action( 'SeanceController@all', [ 'course' => $course->id ] ) !!}"><span class="hidden">Revenir à la page précédente</span><span class="icon-arrow-left"></span></a>
	</div>

	<!-- dd_moreButton -->
	<div class="dd_moreButton">
		<input type="checkbox" id="dd_moreButton">
		<label for="dd_moreButton" class="dd_moreButton--button"><span></span><span></span></label>

		<ul class="dd_moreButton--content">
			@if( Auth::user()->status == 1 )
				<li><a href="{!! action( 'SeanceController@create', ['id' => $course->id] ) !!}">Ajouter des séances de cours…</a></li>
			@endif
		</ul>
	</div>

	<div class="box--group">
		@if ( isset($seances) )
			@if ( count($seances) == 0 )
				<p class="item--null">
					Aucune séance n’est terminée
				</p>
				<p class="center"></p>
			@else
			<div class="box box--demis box--demis--left box--shadow box--seance--course">
				<ul class="box__group--list seance__group--list">
					@foreach( $seances as $seance )
						<li class="box__group--list--list box__seanceCourse @if( $seance->absent == 1 ) course__absenceSeance @endif">
							<a class="box__seanceDate" href="{!! action( 'SeanceController@view', ['id' => $seance->id] ) !!}">
								<span class="box__seanceDate--day">{{ $seance->start_hours->formatLocalized('%A') }}</span>
								<span class="box__seanceDate--dayNumber">{{ $seance->start_hours->formatLocalized('%d') }}</span>
								<span class="box__seanceDate--month">{{ $seance->start_hours->formatLocalized('%B') }}</span>
								<span class="box__highlight box__seanceDate--hour">{{ $seance->start_hours->formatLocalized('%Hh%M') }}</span>
							</a>
							<div class="box__seanceCourse--info">
								<!-- HOMEWORKS -->
								<a href="{!! action( 'SeanceController@view', ['id' => $seance->id] ) !!}#works" class="box__seanceCourse--homework box__seanceCourse--numbers">
									<span class="icon-briefcase"></span>
									@if( count($seance->works) !== 0 )
										Devoirs&#8239;: {{ count($seance->works) }}
									@else
										Devoirs&#8239;: 0
									@endif
								</a>

								<!-- TESTS -->
								<a href="{!! action( 'SeanceController@view', ['id' => $seance->id] ) !!}#tests" class="box__seanceCourse--test box__seanceCourse--numbers">
									<span class="icon-book-open"></span>
									@if( count($seance->tests) !== 0 )
										Tests&#8239;: {{ count($seance->tests) }}
									@else
										Tests&#8239;: 0
									@endif
								</a>

								<!-- COMMENTS -->
								<a href="{!! action( 'SeanceController@view', ['id' => $seance->id] ) !!}#comments" class="box__seanceCourse--comment box__seanceCourse--numbers">
									<span class="icon-bubbles"></span>
									<?php $theSeanceComment = []; ?>
									@foreach( $comments as $comment )
										@if( $comment->for == $seance->id )
											<?php $theSeanceComment[] = $comment; ?>
										@endif
									@endforeach
									@if( !empty($theSeanceComment) )
										Com&#8239;: {{ count($theSeanceComment) }}
									@else
										Com&#8239;: 0
									@endif
								</a>
							</div>
							<div class="clear"></div>
						</li>
					@endforeach
					@if( $seances->render() )
						<li class="box__group--list--list box__seanceCourse">
							{!! $seances->render() !!}
						</li>
					@endif
				</ul>
			</div>
		@endif
	@endif
	</div>

@endsection