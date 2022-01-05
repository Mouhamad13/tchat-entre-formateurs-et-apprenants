@extends('layout')
@section('title', $title)
@section('content')
	<div class="blockTitle">
		<h2 class="mainTitle">Notifications</h2>
	</div>

	<!-- dd_moreButton -->
	<div class="dd_moreButton">
		<input type="checkbox" id="dd_moreButton">
		<label for="dd_moreButton" class="dd_moreButton--button"><span></span><span></span></label>
		<ul class="dd_moreButton--content">
			@if( \Auth::user()->status == 1 )
				<li><a href="{!! action( 'CourseController@create' ) !!}">Créer un cours…</a></li>
			@else
				<li><a href="{!! action( 'CourseController@searchCourse' ) !!}">Ajouter un cours…</a></li>
			@endif
		</ul>
	</div>

	@if( Auth::check() )
		<ul class="notification__group__page">
			@if ( count($notifications) != 'null' )
				@foreach ($notifications as $not)
					@include( 'notifications.notificationContent' )
				@endforeach
			{!! $notifications->render() !!}
		@else
			<li class="item--null">Aucune notification pour le moment</li>
		@endif
		</ul>
	@endif

@endsection