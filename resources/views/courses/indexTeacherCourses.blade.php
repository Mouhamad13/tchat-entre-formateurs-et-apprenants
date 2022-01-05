@extends( 'layout' )
	@section('title', $title)
    @section( 'content' )
		<div class="blockTitle">
			<h2 class="mainTitle">Tous mes cours</h2>
		</div>

		<!-- dd_moreButton -->
		<div class="dd_moreButton">
			<input type="checkbox" id="dd_moreButton">
			<label for="dd_moreButton" class="dd_moreButton--button"><span></span><span></span></label>

			<ul class="dd_moreButton--content">
				<li><a href="{!! action( 'CourseController@create' ) !!}">Créer un cours…</a></li>
			</ul>
		</div>

		<ul class="list__course_box--group">
			@if ( $courses->count() == null )
				<!-- <li class="list__empty">Aucun cours pour le moment</li> -->
			@endif
			@foreach ($courses as $course)
				<li class="list__course_box--list course_box">
					<a href="{!! action( 'CourseController@view', [ 'id' => $course->id ] ) !!}">
						<span class="hidden">Voir le cours</span>
						<h3>
							<span class="box_subTitle">Cours de </span>
							<span class="box_mainTitle">{{ $course->title }} </span>
							<span class="box_subTitle">Groupe {{ $course->group }}</span>
						</h3>
					</a>
				</li>
			@endforeach
	    		<li class="list__course_box--list--add list__course_box--list course_box noprint">
	    			<a href="{!! action( 'CourseController@create' ) !!}">
						<p class="list__course_box--list--add--text">Créer un nouveau cours</p>
						<span></span>
						<span></span>
					</a>
	    		</li>
    	</ul>
    	@include( 'errors.profilError' )
@stop