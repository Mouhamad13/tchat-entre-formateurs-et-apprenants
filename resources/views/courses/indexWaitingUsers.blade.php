@extends( 'layout' )
@section( 'content' )
@section( 'title', $title )

<div class="blockTitle">
    <h2 class="mainTitle">Les élèves qui demandent accès au cours</h2>
    <a title="Revenir au cours" class="backButton blockTitle__backButton unlink mainColorfont" href="{!! action( 'CourseController@view', [ 'id' => $course->id ] ) !!}"><span class="hidden">Revenir au cours</span><span class="icon-arrow-left"></span></a>
</div>

<!-- dd_moreButton -->
<div class="dd_moreButton">
    <input type="checkbox" id="dd_moreButton">
    <label for="dd_moreButton" class="dd_moreButton--button"><span></span><span></span></label>

    <ul class="dd_moreButton--content">
        <li><a href="{!! action( 'CourseController@create' ) !!}">Ajouter un cours…</a></li>
    </ul>
</div>

<div class="box--group">
    @if ( count($demandedStudents) !== 0 )
        <ul>
            <div class="box box--shadow">
                @foreach( $demandedStudents as $student )
                    <li class="box__group--list--list box__group--studentAsk">
                        <a class="profilPicName" href="{{ action( 'PageController@viewUser', [ 'id' => $student->id ] ) }}">
                            <img class="box__profilImage box__profilImage--small" src="{{ url() }}/img/profilPicture/{{ $student->image }}" alt="Image de profil">
                            <span>{{ $student->firstname }} {{$student->name}}</span>
                        </a>

                        <a class="icon icon-close unlink danger rightBox" href="{!! action( 'CourseController@removeStudentFromCourse', ['id_course' => $course->id, 'id_user' => $student->id] ) !!}"><span class="hidden">Refuser l’accès</span></a>

                        <a class="icon icon-check unlink success rightBox" href="{!! action( 'CourseController@acceptStudent', ['id_course' => $course->id, 'id_user' => $student->id] ) !!}"><span class="hidden">Ajouter</span></a>

                        <div class="clear"></div>
                    </li>
                @endforeach
            </div>
        </ul>
    @else
        <p class="item--null">Aucune demande pour le moment</p>
    @endif
</div>

@stop