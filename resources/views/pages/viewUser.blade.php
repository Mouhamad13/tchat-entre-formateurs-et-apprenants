@extends('layout')
@section('title', $title)
@section('content')
	<div class="blockTitle">
		<h2 class="mainTitle">Profil de {{ $user->firstname }} {{ $user->name }}</h2>
		<a class="backButton blockTitle__backButton unlink mainColorfont" href="{!! URL::previous() !!}"><span class="hidden">Revenir à la page précédente</span><span class="icon-arrow-left"></span></a>
	</div>

	<!-- dd_moreButton -->
	<div class="dd_moreButton">
		<input type="checkbox" id="dd_moreButton">
		<label for="dd_moreButton" class="dd_moreButton--button"><span></span><span></span></label>

		<ul class="dd_moreButton--content">
			<li><a href="mailto:{{$user->email}}">Contacter par mail</a></li>
		</ul>
	</div>

	<div class="box--group">
		<!-- Profil photo -->
		<div class="box_profilPicture box__profilImage box__profilImage--profilPage">
			<img class="box__profilImage" src="{{ url() }}/img/profilPicture/{{ $user->image }}" alt="Image de profil">
		</div>

		<!-- id information -->
		<div class="box box--shadow box_profil--picture">
			<ul class="box__group--list profil__group--list">
				<li class="box__group--list--list box__profilInformation">
					<h3><span class="icon icon--text icon--text--aboutPage icon-user mainColorfont"></span> {{ $user->firstname }} {{ $user->name }}</h3>
				</li>
				<li class="box__group--list--list box__profilInformation">
					<a class="unlink" title="Contacter {{ $user->firstname }} {{ $user->name }}" href="mailto:{{$user->email}}">
						<span class="icon icon--text icon--text--aboutPage icon-envelope mainColorfont"></span>
						{{ $user->email }}
					</a>
				</li>
				<li class="box__group--list--list box__profilInformation">
					<span class="icon icon--text icon--text--aboutPage icon-badge mainColorfont"></span>
					@if( $user->status == 1 )
						Professeur
					@else
						Élève
					@endif
				</li>
			</ul>
		</div>

		@if( $user->status == 1 )
			<!-- id course -->
			<div class="box box--shadow">
				<ul class="box__group--list profil__group--list">
					<li class="box__group--list--list box__profilCourse box__profilCourse--title">
						<h3>Ensemble de ses cours</h3>
					</li>

					@foreach( $courses as $course )
						<li class="box__group--list--list box__profilCourse">
							<h4>
								<a class="unlink blockLink" href="{{ action( 'CourseController@view', [ 'id' => $course->id ] ) }}">
									<span class="icon icon--text icon--text--aboutPage icon-briefcase mainColorfont"></span> Cours de {{ $course->title }}
									<br>
									<span class="icon icon--text icon--text--aboutPage icon-users mainColorfont"></span> Groupe {{ $course->group }}
								</a>
							</h4>
						</li>
					@endforeach

				</ul>
			</div>
		@endif

	</div>
@endsection