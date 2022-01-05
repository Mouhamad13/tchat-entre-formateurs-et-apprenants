@extends( 'layout' )
@section( 'content' )
@section( 'title', $title )

<div class="blockTitle">
	<h2 class="mainTitle">Liste de mes élèves</h2>

	<a title="Revenir à la page de profil" class="backButton blockTitle__backButton unlink mainColorfont" href="{!! action( 'PageController@about' ) !!}"><span class="hidden">Revenir à la page précédente</span><span class="icon-arrow-left"></span></a>
</div>

@if ( count($students) !== 0 )
	<div class="box--group">
		<div class="box box--shadow box--studentAll">
			<ul>
				@foreach ($students as $student)
					<li class="box__group--list--list box__group--students">
						<a class="profilPicName list__users--middle" href="{{ action( 'PageController@viewUser', [ 'id' => $student[0]->id ] ) }}">
							<img class="box__profilImage box__profilImage--small" src="{{ url() }}/img/profilPicture/{{ $student[0]->image }}" alt="Image de profil">
							<span>{{ $student[0]->firstname }} {{$student[0]->name}}</span>
						</a>
						<div class="box__list__rightButtons">
							<a title="Contacter par mail" class="unlink box__list__rightButton" href="mailto:{{ $student[0]->email }}">
								<span class="hidden">Contacter</span>
								<span class="icon-envelope"></span>
							</a>
							@if( \Auth::user()->status == 1 )
								<a title="Retirer cet élève de tout mes cours" class="unlink box__list__rightButton deleteButtonBg" href="{!! action( 'CourseController@removeStudent', ['id' => $student[0]->id] ) !!}">
									<span class="hidden">Retirer de tout mes cours</span>
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