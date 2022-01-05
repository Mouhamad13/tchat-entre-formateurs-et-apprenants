<?php use Carbon\Carbon;
Carbon::setLocale('fr'); ?>
<?php use App\User; ?>

@extends( 'layout' )
    @section( 'content' )
    @section( 'title', $title )

	<div class="blockTitle">
		<h2 class="mainTitle"><span class="hidden">Séance du </span>{{ $seance->start_hours->formatLocalized('%A %d %B %Y') }}</h2>
		<h3 class="subTitle">Cours de {{ $seance->course->title }}</h3>
		@if( \Auth::user()->status == 1 )
			<a title="Modifier la séance" href="{!! action( 'SeanceController@edit', [ "id" => $seance->id ] ) !!}" class="unlink mainColorfont blockTitle--edit">
				<span class="icon-pencil icon icon--edit"></span> <span class="hidden">Modifier la séance</span>
			</a>
		@endif
		<h4 class="bannerUnderTitle seanceDuration" title="de {{ $seance->start_hours->formatLocalized('%Hh%M') }} à {{ $seance->end_hours->formatLocalized('%Hh%M') }}">
			<span class="icon-clock"></span>&nbsp;{{ $seance->start_hours->formatLocalized('%Hh%M') }} - {{ $seance->end_hours->formatLocalized('%Hh%M') }}
		</h4>
		@if( $seance->absent == 1 )
			<h3 class="seanceAbsence--title">!! La séance est annulée pour cause d'absence du professeur !!</h3>
		@endif
		<h4 class="bannerUnderTitle seanceLocal" title="de {{ $seance->start_hours->formatLocalized('%Hh%M') }} à {{ $seance->end_hours->formatLocalized('%Hh%M') }}">
			<span class="icon-pointer"></span>&nbsp;Local&nbsp;: {{ $seance->local == null ? 'Aucun local précisé' : $seance->local }}
		</h4>
		<a title="Revenir au cours" class="backButton blockTitle__backButton unlink mainColorfont" href="{!! action( 'CourseController@view', [ 'id' => $seance->course->id ] ) !!}"><span class="hidden">Revenir à la page précédente</span><span class="icon-arrow-left"></span></a>
	</div>

	@if ( \Auth::user()->status == 1 )
			<!-- dd_moreButton -->
	<div class="dd_moreButton">
		<input type="checkbox" id="dd_moreButton">
		<label for="dd_moreButton" class="dd_moreButton--button"><span></span><span></span></label>

		<ul class="dd_moreButton--content">
			<li><a href="{!! action( 'WorkController@create', ['id' => $seance->id, 'info' => 'seance'] ) !!}">Créer un devoir…</a></li>
			<li><a href="{!! action( 'TestController@create', ['id' => $seance->id, 'info' => 'seance'] ) !!}">Créer une interrogation…</a></li>
			<li><a href="{!! action( 'SeanceController@absent', [ "id" => $seance->id ] ) !!}">
					@if(  $seance->absent == 0 )
						Je serai absent(e)
					@else
						Je serai présent
					@endif
				</a>
			</li>
			<li><a href="{!! action( 'SeanceController@edit', [ "id" => $seance->id ] ) !!}">Modifier la séance…</a></li>
			<li><a class="action__deleteSeance" data-page="seance" data-course="{{ $seance->course->id }}" href="{!! action( 'SeanceController@delete', [ "id" => $seance->id ] ) !!}">Supprimer la séance</a></li>
			<li><a href="{!! action( 'CourseController@create' ) !!}">Créer un autre cours…</a></li>
		</ul>
	</div>
	@endif

	<ul class="shutters--group @if( $seance->absent == 1 ) shutters--group--absence @endif">
		<!-- Works -->
		<li class="shutter shutter__seance shutter__seance--works">
			<h3 id="works" class="shutterTitle shutterTitle--works"><span title="ouvrir/réduire" class="icon-arrow-down icon"></span> DEVOIRS
				@if( count( $seance->works ) == 0 )
					(<span class="shutterTitle--works--number">0</span>)
				@else
					(<span class="shutterTitle--works--number">{{ count( $seance->works ) }}</span>)
				@endif
			@if( \Auth::user()->status == 1 )
				<a class="unlink whiteText shutterTitle--addButton noprint" href="{!! action( 'WorkController@create', ['id' => $seance->id, 'info' => 'seance'] ) !!}"></span>Ajouter</a>
			@endif
			</h3>
			<div class="box--group">
				@if ( count($seance->works) == 0 )
					<p class="center center--empty">Aucun devoir</p>
				@else
					@foreach ($seance->works as $work)
						<div class="box box--shadow box--work">
							<div class="box__head">
								<h4 class="box__blockTitle box__blockTitle--dark @if ( \Auth::user()->status == 1 ) teacher @endif">
									{{ $work->title }}
								</h4>
								@if ( \Auth::user()->status == 1 )
									<div class="boxTitle__teahcerIcon--group">
										<a title="Modifier" class="icon icon-note unlink boxTitle__editIcon boxTitle__teacherIcon" href="{{ action( 'WorkController@edit', ['id' => $work->id] ) }}">
											<span class="hidden">modifier</span>
										</a>
										<a title="Supprimer" data-seance="{{ $seance->id }}" class="action__deleteWork icon icon-trash unlink boxTitle__deleteIcon boxTitle__teacherIcon" href="{!! action( 'WorkController@delete', ['id' => $work->id] ) !!}">
											<span class="hidden">Supprimer</span>
										</a>
										<div class="clear"></div>
									</div>
								@endif
							</div>
							<div class="box__group--content">
								{{ $work->description }}
							</div>
							@if( count( $work->files ) != 0 )
								<ul class="box__group--files">
									@foreach( $work->files as $file )
										<li class="box__list--files">
											<a class="box__link--files unlink" download="proposed_file_name" href="{{ url() }}/files/{{ $file->filename }}">
												<span class="icon-folder-alt icon icon--text mainColorfont"></span>
												<div class="file__list--right">
													<span>{{ $file->title }}</span>
													<span>{{ round($file->size) < 1000 ? round($file->size).' Ko' : round($file->size/1000, 2).' Mo' }}</span>
												</div>
											</a>
										</li>
									@endforeach
								</ul>
							@endif
						</div>
					@endforeach
				@endif
			</div>
		</li>

		<!-- Tests -->
		<li class="shutter shutter__seance shutter__seance--tests">
			<h3 id="tests" class="shutterTitle shutterTitle--tests"><span title="ouvrir/réduire" class="icon-arrow-down icon"></span> INTERROGATIONS
					@if( count($seance->tests) == 0 )
						(<span class="shutterTitle--tests--number">0</span>)
					@else
						(<span class="shutterTitle--tests--number">{{ count( $seance->tests ) }}</span>)
					@endif

				@if( \Auth::user()->status == 1 )
					<a class="unlink whiteText shutterTitle--addButton noprint" href="{!! action( 'TestController@create', ['id' => $seance->id, 'info' => 'seance'] ) !!}"></span>Ajouter</a>
				@endif
			</h3>
			<div class="box--group">
				@if ( count($seance->tests) == 0 )
					<p class="center center--empty">Aucune interrogation</p>
				@else
					@foreach ($seance->tests as $test)
						<div class="box box--shadow box--test">
							<div class="box__head">
								<h4 class="box__blockTitle box__blockTitle--dark @if ( \Auth::user()->status == 1 ) teacher @endif">
									{{ $test->title }}
								</h4>
								@if ( \Auth::user()->status == 1 )
									<div class="boxTitle__teahcerIcon--group">
										<a title="Modifier" class="icon icon-note unlink boxTitle__editIcon boxTitle__teacherIcon" href="{{ action( 'TestController@edit', ['id' => $test->id] ) }}">
											<span class="hidden">modifier</span>
										</a>
										<a title="Supprimer" data-seance="{{ $seance->id }}" class="action__deleteTest icon icon-trash unlink boxTitle__deleteIcon boxTitle__teacherIcon" href="{!! action( 'TestController@delete', ['id' => $test->id] ) !!}">
											<span class="hidden">Supprimer</span>
										</a>
										<div class="clear"></div>
									</div>
								@endif
							</div>
							<div class="box__group--content">
								{{ $test->description }}
							</div>
							@if( count( $test->files ) != 0 )
								<ul class="box__group--files">
									@foreach( $test->files as $file )
										<li class="box__list--files">
											<a class="box__link--files unlink" download="proposed_file_name" href="{{ url() }}/files/{{ $file->filename }}">
												<span class="icon-folder-alt icon icon--text mainColorfont"></span>
												<div class="file__list--right">
													<span>{{ $file->title }}</span>
													<span>{{ round($file->size) < 1000 ? round($file->size).' Ko' : round($file->size/1000, 2).' Mo' }}</span>
												</div>
											</a>
										</li>
									@endforeach
								</ul>
							@endif
						</div>
					@endforeach
				@endif
			</div>
		</li>

		<!-- Comments -->
		<li class="shutter shutter__seance shutter__seance--comments">
			<h3 id="comments" class="shutterTitle shutterTitle--comments"><span title="ouvrir/réduire" class="icon-arrow-down icon"></span> COMMENTAIRES
					@if(count($comments) == 0)
						(<span class="shutterTitle--comments--number">0</span>)
					@else
						(<span class="shutterTitle--comments--number">{{ count($comments) }}</span>)
					@endif
			</h3>
				<div class="box--group">
					@if ( isset($comments) )
						@if ( count($comments) == 0 )
							<p class="center center--empty">Aucun commentaire</p>
						@else
						<div class="box box--shadow box--comment">
							<ul class="box__group--comment">
							@foreach ($comments as $comment)
								<?php $user = User::findOrFail($comment->from); ?>
								<li class="box__group--comment--item">
									<a class="comment_profilPicName profilPicName" href="
										@if( $user->id == \Auth::user()->id )
											{{ action( 'PageController@about' ) }}
										@else
											{{ action( 'PageController@viewUser', [ 'id' => $user->id ] ) }}
										@endif
									">
										<img class="box__profilImage box__profilImage--comment box__profilImage--small" src="{{ url() }}/img/profilPicture/{{ $user->image }}" alt="Image de profil">
										@if( $user->id == \Auth::user()->id )
											<span>moi</span>
										@else
											<span>{{ $user->firstname }} {{$user->name}}</span>
										@endif
									</a>
									<div class="box--comment--content--group ">
										<div class="box--comment--content @if( \Auth::user()->status == 1 ) box--comment--content--teacher @endif">
											<?= $comment->body; ?>
												<p class="time"><?= $comment->created_at->diffForHumans(); ?></p>
										</div>
									</div>
									<div class="clear"></div>
									@if( \Auth::user()->status == 1 or $comment->from == \Auth::user()->id )
										<a title="Supprimer" class="icon icon-trash unlink comment__icon--delete" href="{!! action( 'CommentController@delete', ['id' => $comment->id] ) !!}">
											<span class="hidden">Supprimer</span>
										</a>
									@endif
								</li>
							@endforeach
							</ul>
						@endif
							<form class="comment__box" method="POST" action="/comment/create">
								{!! csrf_field() !!}

								<div class="form-group">
									<label class="hidden" for="comment">Votre commentaire</label>
									<textarea class="comment__box--textarea" name="comment" id="comment" placeholder="Votre commentaire…"></textarea>
									<input type="hidden" name="context" value="1">
									<input type="hidden" name="for" value="<?= $seance->id; ?>">
									<!-- /!\ Afficher les erreurs -->

									<button title="Envoyer le commentaire" class="comment__box--button" type="submit">
										<span class="icon icon-arrow-up mainColorfont"></span>
										<span class="hidden">Envoyer</span>
									</button>
									<div class="clear"></div>
								</div>

							</form>
						@endif
					</ul>
			</div>
		</li>
	</ul>
@stop