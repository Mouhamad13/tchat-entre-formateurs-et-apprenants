<?php use App\User; ?>
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
				<li><a href="{!! action( 'CourseController@searchCourse' ) !!}">Ajouter un cours…</a></li>
			</ul>
		</div>

		@if ( $courses->count() != null )
			@if ( count($waitCourses) != null )
				<li class="unlist waitCourse--link">
					<a class="unlink" href="{!! action( 'CourseController@waitCourse' ) !!}">
						<span class="icon-info icon icon--text"></span>
						{{ count($waitCourses) }} cours en attente de validation
					</a>
				</li>
			@endif
		@endif

		<ul class="list__course_box--group">
			@if ( $courses->count() == null )
				<!-- <li class="list__empty">Aucun cours pour le moment</li>  -->
			@endif
				@foreach( $courses as $course )
					@if ( $course->pivot->access == 2 )
						<li class="list__course_box--list course_box">
							<a href="{!! action( 'CourseController@view', [ 'id' => $course->id ] ) !!}">
								<span class="hidden">Voir le cours</span>
								<h3>
									<span class="box_subTitle">Cours de </span>
									<span class="box_mainTitle">{{ $course->title }} </span>
									@foreach( $teachers as $teacher )
										@if( $course->teacher_id == $teacher->id )
											<span class="box_subTitle">{{ $teacher->firstname }} {{ $teacher->name }}</span>
										@endif
									@endforeach
								</h3>
							</a>
						</li>
					@endif
				@endforeach
				<li class="list__course_box--list--add list__course_box--list course_box noprint">
	    			<a href="{!! action( 'CourseController@searchCourse' ) !!}">
						<p class="list__course_box--list--add--text">Ajouter un cours</p>
						<span></span>
						<span></span>
					</a>
	    		</li>
			</ul>
@stop