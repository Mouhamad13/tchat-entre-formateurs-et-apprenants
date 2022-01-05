@extends('layout')
@section('title', $title)
@section('content')
	<div class="blockTitle">
		<h2 class="mainTitle">Mon profil</h2>
		<a href="{!! action( 'PageController@editProfil' ) !!}" class="unlink mainColorfont blockTitle--edit">
			<span class="icon-pencil icon icon--edit"></span> <span class="hidden">Modifier mon profil</span>
		</a>
	</div>

	<!-- dd_moreButton -->
	<div class="dd_moreButton">
		<input type="checkbox" id="dd_moreButton">
		<label for="dd_moreButton" class="dd_moreButton--button"><span></span><span></span></label>

		<ul class="dd_moreButton--content">
			<li><a href="{{ action( 'PageController@changePicture' ) }}">Changer la photo de profil…</a></li>
			<li><a href="{!! action( 'PageController@editProfil' ) !!}">Modifier mon profil…</a></li>
			<li><a class="action__deleteProfil" href="{!! action( 'PageController@deleteProfil' ) !!}">Supprimer mon compte</a></li>
			@if( Auth::user()->status == 1 )
				<li><a href="{!! action( 'CourseController@create' ) !!}">Créer un cours…</a></li>
			@endif
		</ul>
	</div>

	<div class="box--group">
		<!-- Profil photo -->
		<div class="box_profilPicture box__profilImage box__profilImage--profilPage">

			<img class="box__profilImage" src="{{ url() }}/img/profilPicture/{{ Auth::user()->image }}" alt="Image de profil">
			<a class="" href="{{ action( 'PageController@changePicture' ) }}">Changer la photo</a>

		</div>

		<!-- id information -->
		<div class="box box--demis box--demis--left box--shadow box_profil--picture">
			<ul class="box__group--list profil__group--list">
				<li class="box__group--list--list box__profilInformation">
					<h3><span class="icon icon--text icon--text--aboutPage icon-user mainColorfont"></span> {{ Auth::user()->firstname }} {{ Auth::user()->name }}</h3>
				</li>
				<li class="box__group--list--list box__profilInformation">
					<span class="icon icon--text icon--text--aboutPage icon-envelope mainColorfont"></span> {{ Auth::user()->email }}
				</li>
				<li class="box__group--list--list box__profilInformation">
					<span class="icon icon--text icon--text--aboutPage icon-badge mainColorfont"></span>
					@if( Auth::user()->status == 1 )
					Professeur
					@else
					Élève
					@endif
				</li>
			</ul>
		</div>

		<!-- Course information -->
		<div class="box box--demis box--demis--right box--shadow">
			<ul class="box__group--list profil__group--list">
				@if( Auth::user()->status == 1 )
					<li class="box__group--list--list box__profilInformation">
						<a class="unlink" href="{{ action( 'CourseController@index' ) }}">
							<span class="icon icon--text icon--text--aboutPage icon-briefcase mainColorfont"></span><span class="hidden">Nombre de cours&nbsp:</span>
							<span> {{ $nbCourses }} cours</span>
						</a>
					</li>
					<li class="box__group--list--list box__profilInformation">
						<a class="unlink" href="{{ action( 'CourseController@indexUserUsers' ) }}">
							<span class="icon icon--text icon--text--aboutPage icon-users mainColorfont"></span><span class="hidden">Nombre d'élèves&nbsp:</span>
							@if( $nbUsers == 1 )
								<span> {{ $nbUsers }} élève</span>
							@else
								<span> {{ $nbUsers }} élèves</span>
							@endif
						</a>
					</li>
				@elseif( Auth::user()->status == 2 )
					<li class="box__group--list--list box__profilInformation">
						<a class="unlink" href="{{ action( 'CourseController@index' ) }}">
							<span class="icon icon--text icon--text--aboutPage icon-graduation mainColorfont"></span><span class="hidden">Cours suivis&nbsp:</span>
							<span> {{ $nbCoursesStudent }} cours suivi</span>
						</a>
					</li>
				@endif
			</ul>
		</div>

		<!-- color theme -->
		<div class="box box--demis box--demis--right box--shadow clear-right">
			<ul class="box__group--list profil__group--list">
				<li class="box__group--list--list box__profilInformation">
					<span class="icon icon--text icon--text--aboutPage icon-heart icon-user mainColorfont"></span>
					Thème couleur
					<a class="theme__color--profil" href="{{ action( 'PageController@changeColor' ) }}" title="Changer la couleur du thème"><span class="hidden">Changer la couleur du thème</span></a>
				</li>
			</ul>
		</div>
	</div>

@endsection