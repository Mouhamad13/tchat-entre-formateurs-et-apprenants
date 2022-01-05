<?php 	
		 	$monday = Carbon::now()->startOfWeek();
			$tuesday = Carbon::now()->startOfWeek()->addDays(1);
			$wednesday = Carbon::now()->startOfWeek()->addDays(2);
			$thurstday = Carbon::now()->startOfWeek()->addDays(3);
			$friday = Carbon::now()->startOfWeek()->addDays(4);
			$saturday = Carbon::now()->startOfWeek()->addDays(5);
			$sunday = Carbon::now()->startOfWeek()->addDays(6);
		 ?>

		<div class="planning">
		<h3>{{ $monday->formatLocalized('%A %d %B %Y') }}</h3>
		
		<h3>{{ $tuesday->formatLocalized('%A %d %B %Y') }}</h3>

		<h3>{{ $wednesday->formatLocalized('%A %d %B %Y') }}</h3>

		<h3>{{ $thurstday->formatLocalized('%A %d %B %Y') }}</h3>

		<h3>{{ $friday->formatLocalized('%A %d %B %Y') }}</h3>

		<h3>{{ $saturday->formatLocalized('%A %d %B %Y') }}</h3>

		<h3>{{ $sunday->formatLocalized('%A %d %B %Y') }}</h3>

	<ul class="list-group">
		@foreach ($seances as $seance)
			@foreach ($seance as $the_seance)
				<li class="list-group-item">
					<dt>Séance du {{ $the_seance->start_hours->formatLocalized('%A %d %B %Y') }} à {{ $the_seance->start_hours->formatLocalized('%Hh%M') }}</dt>
					<br>
					@if ( count($the_seance->works) != 0 )
						<dt>Devoir:</dt>
						@foreach ($the_seance->works as $work)
							<dd>{{ $work->title }}</dd>
						@endforeach
					@endif
					@if ( count($the_seance->tests) != 0 )
						<dt>Interrogation:</dt>
						@foreach ($the_seance->tests as $test)
							<dd>{{ $test->title }}</dd>
						@endforeach
					@endif
				</li>
			@endforeach
		@endforeach 
	</ul>

	</div>