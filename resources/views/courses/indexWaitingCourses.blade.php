<?php use App\User; ?>
@extends( 'layout' )
@section('title', $title)
@section( 'content' )

    <div class="blockTitle">
        <h2 class="mainTitle">Cours en attente de validation</h2>
        <a title="Revenir à la page précédente" class="backButton blockTitle__backButton unlink mainColorfont" href="{!! action( 'CourseController@index' ) !!}"><span class="hidden">Revenir à la page précédente</span><span class="icon-arrow-left"></span></a>
    </div>

    <!-- dd_moreButton -->
    <div class="dd_moreButton">
        <input type="checkbox" id="dd_moreButton">
        <label for="dd_moreButton" class="dd_moreButton--button"><span></span><span></span></label>

        <ul class="dd_moreButton--content">
            <li><a href="{!! action( 'CourseController@searchCourse' ) !!}">Ajouter un cours…</a></li>
        </ul>
    </div>


    <div class="box--group">
        @if( !empty($waitCourses) )
            <div class="box box--shadow box--studentAll">
                <ul>
                    @foreach( $waitCourses as $waitCourse )
                        <li class="box__group--list--list box__group--waitCourses">
                            <div class="box__list__leftContent">
                                <p class="box__group--waitCourses--courseTitle">Cours de {{ $waitCourse->title }}</p>
                                <p>groupe {{ $waitCourse->group }}</p>
                            </div>

                            <div class="box__list__rightButtons">
                                <a title="Annuler la demande d’accès" class="unlink box__list__rightButton deleteButtonBg" href="{!! action( 'CourseController@removeCourse', [ 'id' => $waitCourse->id ] ) !!}">
                                    <span class="icon-trash"></span>
                                    <span class="smallHidden">Annuler</span>
                                </a>
                                <div class="clear"></div>
                            </div>
                            <div class="clear"></div>
                        </li>
                    @endforeach
                </ul>
            </div>
        @else
            <li class="item--null unlist">
                Aucun cours en attente pour le moment
            </li>
        @endif
    </div>

@stop