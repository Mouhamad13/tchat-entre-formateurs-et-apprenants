@extends( 'layout' )
	@section('title', $title)
    @section( 'content' )

    <div class="blockTitle">
        <h2 class="mainTitle">Modifier l'interrogation</h2>

        <a title="Revenir à la séance" class="backButton blockTitle__backButton unlink mainColorfont" href="{!! action( 'SeanceController@view', ['id' => $test->seance->id] ) !!}"><span class="hidden">Revenir à la page précédente</span><span class="icon-arrow-left"></span></a>

    </div>

    <div class="box--group">
        <div class="box box--shadow">
            <form class="box__group--content" action="" method="post" enctype="multipart/form-data">
                @include( 'errors.profilError' )

                <div class="form-group">
                    <label class="color_label" for="course">Pour quel cours?</label>
                    <select class="form-control" name="course" id="course_seance">

                    @foreach ($allCourses as $singleCourse)
                        <option value="{{ $singleCourse->id }}"
                        @if( isset( $course ) )
                            @if( isset( $seance ) )
                                <?php $courseId = $course[0]->id; ?>
                            @else
                                <?php $courseId = $course->id; ?>
                            @endif
                            <?php $singleCourseId = $singleCourse->id; ?>
                                @if( $singleCourseId == $courseId )
                                    selected="selected"
                                @endif
                        @endif
                        >{{ $singleCourse->title }} groupe {{ $singleCourse->group }}</option>
                    @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label class="color_label" for="seance">Pour quelle séance de cours?</label>
                    <select class="form-control" name="seance" id="seance">
                        @foreach ($allSeances as $singleSeance)
                            <option value="{{ $singleSeance->id }}"
                            @if ( isset( $seance ) )
                                <?php $singleSeanceId = $singleSeance->id;
                                  $seanceId = $seance->id; ?>
                                @if( $singleSeanceId == $seanceId )
                            selected="selected"
                            @endif @endif >Séance du {{ $singleSeance->start_hours->formatLocalized('%A %d %B %Y') }} de {{ $singleSeance->start_hours->formatLocalized('%Hh%M') }} à {{ $singleSeance->end_hours->formatLocalized('%Hh%M') }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <label class="color_label" for="title">Titre de l'interrogation</label>
                    <input type="text" class="form-control" name="title" id="title" placeholder="ex: test de propabilité" value="{{ $test->title }}">
                </div>

                <div class="form-group">
                    <label class="color_label" for="descr">Description de l'interrogation</label>
                    <textarea class="form-control" name="descr" id="descr" cols="30" rows="10" placeholder="ex: La matière de cette interrogation portera sur…">{{$test->description}}</textarea>
                </div>
                <div class="form-group">
                    <ul class="box__group--files">
                        @if( count( $test->files ) != 0 )
                            @foreach( $test->files as $file )
                                <li class="box__list--files">
                                    <a class="box__link--files unlink" download="proposed_file_name" href="{{ url() }}/files/{{ $file->filename }}">
                                        <span class="icon-folder-alt icon icon--text mainColorfont"></span>
                                        <div class="file__list--right">
                                            <span>{{ $file->title }}</span>
                                            <span>{{ round($file->size) < 1000 ? round($file->size).' Ko' : round($file->size/1000, 2).' Mo' }}</span>
                                        </div>
                                    </a>
                                    <a href="{{ action( 'TestController@deleteFile', ['id_file' => $file->id, 'test_id' => $test->id] ) }}" class="unlink danger deleteFile"><span class="hidden">Supprimer ce fichier</span><span class="icon-close"></span></a>
                                </li>
                            @endforeach
                        @endif
                        <li class="form-group--file changedFile">
                            <label class="file_label" for="file">
                                <span class="icon-paper-clip icon--text icon"></span>
                                <span class="fileRightText fileRightText--1">Ajouter des fichiers</span>
                                <span class="smallText fileRightText fileRightText--2">(facultatif - PDF, image ou Word)</span>
                            </label>
                            <input type="file" id="file" name="file[]" multiple>
                        </li>
                    </ul>
                </div>

                <div class="form-group--button text-center">
                    <input type="submit" class="btn btn-send" value="Valider l'interrogation">
                    <div class="clear"></div>
                </div>

            </form>
        </div>
    </div>
@stop