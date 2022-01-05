@extends( 'layout' )
	@section('title', $title)
    @section( 'content' )
    <div class="blockTitle">
        <h2 class="mainTitle">Créer un devoir</h2>

        @if (isset( $seance ))
            <a title="Revenir à la séance" class="backButton blockTitle__backButton unlink mainColorfont" href="{!! action( 'SeanceController@view', ['id' => $seance->id] ) !!}"><span class="hidden">Revenir à la page précédente</span><span class="icon-arrow-left"></span></a>
        @elseif ( isset( $course ) )
            <a title="Revenir au cours" class="backButton blockTitle__backButton unlink mainColorfont" href="{!! action( 'CourseController@view', ['id' => $course->id, 'status' => 1] ) !!}"><span class="hidden">Revenir à la page précédente</span><span class="icon-arrow-left"></span></a>
        @else
            <a title="Revenir à la page précédente" class="backButton blockTitle__backButton unlink mainColorfont" href="{!! URL::previous() !!}"><span class="hidden">Revenir à la page précédente</span><span class="icon-arrow-left"></span></a>
        @endif

    </div>


    <div class="box--group">
        <div class="box box--shadow">
            <form class="box__group--content" action="" method="post" enctype="multipart/form-data">
                @include( 'errors.profilError' )

                <div class="form-group">
                    <label class="color_label" for="course">Pour quel cours?</label>
                    <select disabled class="form-control" name="course" id="course_seance">

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
                    <label class="color_label" for="title">Titre du devoir</label>
                    <input type="text" class="form-control" name="title" id="title" placeholder="ex: exercice de probabilité" autofocus>
                </div>

                <div class="form-group">
                    <label class="color_label" for="descr">Description du devoir</label>
                    <textarea class="form-control" name="descr" id="descr" cols="30" rows="5" placeholder="ex: La matière de ce devoir portera sur…"></textarea>
                </div>

                <div class="form-group--file changedFile">
                    <label class="color_label file_label" for="file">
                        <span class="icon-paper-clip icon--text icon"></span>
                        <span class="fileRightText fileRightText--1">Fichier joints</span>
                        <span class="smallText fileRightText fileRightText--2">(facultatif - PDF, image ou Word)</span>
                    </label>
                    <input type="file" id="file" name="file[]" multiple>
                </div>

                <div class="form-group text-center">
                    <input type="submit" class="btn btn-send" value="Valider le devoir">
                    <div class="clear"></div>
                </div>

            </form>
        </div>
    </div>
@stop