@extends( 'layout' )
@section( 'content' )
@section( 'title', $title )

<div class="blockTitle">
	<h2 class="mainTitle">Les élèves du cours</h2>
	<a title="Revenir au cours" class="backButton blockTitle__backButton unlink mainColorfont" href="{!! action( 'CourseController@view', [ 'id' => $course->id ] ) !!}"><span class="hidden">Revenir au cours</span><span class="icon-arrow-left"></span></a>
</div>

<!-- dd_moreButton -->
@if( \Auth::user()->status == 1 )
	<div class="dd_moreButton">
		<input type="checkbox" id="dd_moreButton">
		<label for="dd_moreButton" class="dd_moreButton--button"><span></span><span></span></label>

		<ul class="dd_moreButton--content">
			<li><a href="{!! action( 'CourseController@create' ) !!}">Ajouter un cours…</a></li>
		</ul>
	</div>
@endif


@if ( count($inCourseStudents) !== 0 )
	<div class="box--group">
		<div class="box box--shadow box--studentAll">
			<ul>
				@foreach( $inCourseStudents as $student )
					<li class="box__group--list--list box__group--students">
						<a class="profilPicName list__users--middle" href="{{ action( 'PageController@viewUser', [ 'id' => $student->id ] ) }}">
							<img class="box__profilImage box__profilImage--small" src="{{ url() }}/img/profilPicture/{{ $student->image }}" alt="Image de profil">
							<span>{{ $student->firstname }} {{$student->name}}</span>
						</a>
						<div class="box__list__rightButtons">
							<a title="Contacter par mail" class="unlink box__list__rightButton" href="mailto:{{ $student->email }}">
								<span class="hidden">Contacter</span>
								<span class="icon-envelope"></span>
							</a>
							@if( \Auth::user()->status == 1 )
								<a title="Retirer cet élève de mon cours" class="unlink box__list__rightButton deleteButtonBg" href="{!! action( 'CourseController@removeStudentFromCourse', ['id_course' => $course->id, 'id_user' => $student->id] ) !!}">
									<span class="hidden">Retirer de ce cours</span>
									<span class="icon-trash"></span>
								</a>
							@endif
							<div class="clear"></div>
						</div>
						<div class="clear"></div>
					</li>
				@endforeach
			</ul>
		</div>
	</div>
@else
	<p class="item--null">
		Il n’y a aucun étudiant pour le moment
	</p>
@endif

@stop