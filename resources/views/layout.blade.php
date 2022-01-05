@include( 'header' )
<body class="{{ isset(Auth::user()->color) ? Auth::user()->color : '' }}">
	<div class="header">
		<input type="checkbox" id="menuToggle">
		<label for="menuToggle" class="menuToggle"><span></span><span></span><span></span></label>

		<a class="mainLogo--link" href="{!! action( 'CourseController@index' ) !!}"><h1 class="mainLogo--title"></h1></a>
		<img class="mainLogo--print hidden" src="{{ url() }}/img/ alt=" width="270" height="68">

		<nav class="mainNav">
			<h2 class="hidden">Menu principale</h2>
			<ul class="mainNav__ul">
					<li><a class="<?php if ( isset($activePage) && $activePage == 'profil' ) { echo 'active';} ?>" href="{!! action( 'PageController@about' ) !!}"><span class="icon-user unlink whiteText whiteText--icon"></span>{{ Auth::user()->firstname }} {{ Auth::user()->name }}</a></li>
					<li><a class="<?php if ( isset($activePage) && $activePage == 'course' ) { echo 'active';} ?>" href="{!! action( 'CourseController@index' ) !!}">
							@if( \Auth::user()->status == 1 )
							<span class="icon-briefcase unlink whiteText whiteText--icon"></span>
							@else
							<span class="icon-graduation unlink whiteText whiteText--icon"></span>
							@endif
							Mes cours</a>
					</li>
					<li><a class="<?php if ( isset($activePage) && $activePage == 'notification' ) { echo 'active';} ?>" href="{!! action( 'NotificationController@index' ) !!}"><span class="icon-bell unlink whiteText whiteText--icon"></span>Notifications
							<span class="notificationNumer--menu">
								@if ( count($notifications) != 'null' )
									({{ count($notifications) }})
								@endif
							</span></a></li>
					<li><a class="<?php if ( isset($activePage) && $activePage == 'planning' ) { echo 'active';} ?>" href="{!! action( 'CalendarController@view' ) !!}"><span class="icon-calendar unlink whiteText whiteText--icon"></span>Mon planning</a></li>
					<li><a href="{!! action( 'Auth\AuthController@getLogout' ) !!}"><span class="icon-power unlink whiteText whiteText--icon"></span>Se déconnecter</a></li>
			</ul>
		</nav>

		<div class="notification__group__header">
			<h2 class="notification__title">NOTIFICATIONS</h2>
			<ul class="notification__group--box">
				@if ( count($notifications) != 'null' )
					<?php $nNotification = 0; ?>
					@foreach ($notifications as $not)
						@if( $nNotification < 3 )

								@include( 'notifications.notificationContent' )

								<div class="clear"></div>
							<?php $nNotification++; ?>
						@endif
					@endforeach
				@else
					<li class="item--null">
						Aucune notification pour le moment
					</li>
				@endif
				<li class="notification__item--more"><a href="{!! action( 'NotificationController@index' ) !!}">Afficher toutes les news</a></li>
			</ul>
		</div>
	</div>

	<div class="pageContainer">
		@yield('content')
		<div class="clear"></div>
	</div>
@include( 'footer' )
