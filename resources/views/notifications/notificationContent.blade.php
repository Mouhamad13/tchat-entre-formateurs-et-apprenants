<?php
use Carbon\Carbon;
Carbon::setLocale('fr');
setlocale( LC_ALL, 'fr_FR.UTF-8');
?>

@if ($not->not_context == 1)	<!-- DEMANDE D'ACCÈS -->
    <li class="notification__item notification__color notification__color--green">
        <div class="notification__content">
            {{$not->user_firstname}} {{$not->user_name}} demande accès au cours de <a href="{{ action('CourseController@view', [ 'id' => $not->course_id, 'action' => 1 ]) }}">{{$not->course_title}}</a>
            <span class="notification__time"><?= Carbon::createFromFormat('Y-m-d H:i:s', $not->not_created_at)->diffForHumans(); ?></span>
        </div>
        <div class="notification__actionGroup">
            <a class="notification__button icon unlink success" href="{!! action( 'CourseController@acceptStudent', ['id_course' => $not->course_id, 'id_user' => $not->user_id] ) !!}"><span class="icon-check"></span><span class="hidden">Ajouter</span></a>

            <a class="notification__button icon unlink danger" href="{!! action( 'CourseController@removeStudentFromCourse', ['id_course' => $not->course_id, 'id_user' => $not->user_id] ) !!}"><span class="icon-close"></span><span class="hidden">Refuser</span></a>
        </div>
        <div class="clear"></div>

    </li>
@endif

@if ($not->not_context == 2)	<!-- ACCÈS AUTORISÉ -->
    <li class="notification__item notification__color notification__color--green">
        <div class="notification__content">
            Vous avez accès au cours de <a href="{{ action('CourseController@view', [ 'id' => $not->course_id, 'action' => 1 ]) }}">{{$not->course_title}}</a>

            <span class="notification__time"><?= Carbon::createFromFormat('Y-m-d H:i:s', $not->not_created_at)->diffForHumans(); ?></span>
        </div>

        <div class="notification__actionGroup">
            <a title="Archiver" class="notification__button notification__button--archive icon unlink" href="{!! action( 'NotificationController@archive', [ 'id' => $not->not_id ] ) !!}"><span class="icon-trash"></span><span class="hidden">Archiver</span></a>
        </div>
        <div class="clear"></div>
    </li>
@endif

@if ($not->not_context == 3)	<!-- ACCÈS REFUSÉ -->
    <li class="notification__item notification__color notification__color--red">
        <div class="notification__content">
            Votre demande d’accès au cours de  <a href="{{ action('CourseController@view', [ 'id' => $not->course_id, 'action' => 1 ]) }}">{{$not->course_title}}</a> a été refusée

            <span class="notification__time"><?= Carbon::createFromFormat('Y-m-d H:i:s', $not->not_created_at)->diffForHumans(); ?></span>
        </div>

        <div class="notification__actionGroup">
            <a title="Archiver" class="notification__button notification__button--archive icon unlink" href="{!! action( 'NotificationController@archive', [ 'id' => $not->not_id ] ) !!}"><span class="icon-trash"></span><span class="hidden">Archiver</span></a>
        </div>
        <div class="clear"></div>
    </li>
@endif

@if ($not->not_context == 4)	<!-- A QUITTÉ LE COURS -->
    <li class="notification__item notification__color notification__color--red">
        <div class="notification__content">
            {{$not->user_firstname}} {{$not->user_name}} a quitté le cours de <a href="{{ action('CourseController@view', [ 'id' => $not->course_id, 'action' => 1 ]) }}">{{$not->course_title}}</a>

            <span class="notification__time"><?= Carbon::createFromFormat('Y-m-d H:i:s', $not->not_created_at)->diffForHumans(); ?></span>
        </div>

        <div class="notification__actionGroup">
            <a title="Archiver" class="notification__button notification__button--archive icon unlink" href="{!! action( 'NotificationController@archive', [ 'id' => $not->not_id ] ) !!}"><span class="icon-trash"></span><span class="hidden">Archiver</span></a>
        </div>
        <div class="clear"></div>
    </li>
@endif

@if ($not->not_context == 5)	<!-- VOUS N'AVEZ PLUS ACCÈS -->
    <li class="notification__item notification__color notification__color--red">
        <div class="notification__content">
            Vous n’avez plus accès au cours de {{$not->course_title}}
            <span class="notification__time"><?= Carbon::createFromFormat('Y-m-d H:i:s', $not->not_created_at)->diffForHumans(); ?></span>
        </div>

        <div class="notification__actionGroup">
            <a title="Archiver" class="notification__button notification__button--archive icon unlink" href="{!! action( 'NotificationController@archive', [ 'id' => $not->not_id ] ) !!}"><span class="icon-trash"></span><span class="hidden">Archiver</span></a>
        </div>
        <div class="clear"></div>
    </li>
@endif

@if ($not->not_context == 6)	<!-- De nouvelles séances pour le cours -->
    <li class="notification__item notification__color notification__color--green">
        <div class="notification__content">
            De nouvelles séances ont été ajoutées au cours de <a href="{{ action('CourseController@view', [ 'id' => $not->course_id, 'action' => 1 ]) }}">{{$not->course_title}}</a>

            <span class="notification__time"><?= Carbon::createFromFormat('Y-m-d H:i:s', $not->not_created_at)->diffForHumans(); ?></span>
        </div>

        <div class="notification__actionGroup">
            <a title="Archiver" class="notification__button notification__button--archive icon unlink" href="{!! action( 'NotificationController@archive', [ 'id' => $not->not_id ] ) !!}"><span class="icon-trash"></span><span class="hidden">Archiver</span></a>
        </div>
        <div class="clear"></div>
    </li>
@endif

@if ($not->not_context == 7)	<!-- Séance suspendue pour cause d'absence -->
    <li class="notification__item notification__color notification__color--red">
        <div class="notification__content">
            La séance du <a href="{{ action('SeanceController@view', [ 'id' => $not->seance_id ]) }}">{{$not->not_title}}</a> a été suspendue pour le cours de <a href="{{ action('CourseController@view', [ 'id' => $not->course_id ]) }}">{{$not->course_title}}</a>

            <span class="notification__time"><?= Carbon::createFromFormat('Y-m-d H:i:s', $not->not_created_at)->diffForHumans(); ?></span>
        </div>

        <div class="notification__actionGroup">
            <a title="Archiver" class="notification__button notification__button--archive icon unlink" href="{!! action( 'NotificationController@archive', [ 'id' => $not->not_id ] ) !!}"><span class="icon-trash"></span><span class="hidden">Archiver</span></a>
        </div>
        <div class="clear"></div>
    </li>
@endif

@if ($not->not_context == 8)	<!-- Séance rétablie pour cause de non absence du prof -->
    <li class="notification__item notification__color notification__color--green">
        <div class="notification__content">
            La séance du <a href="{{ action('SeanceController@view', [ 'id' => $not->seance_id ]) }}">{{$not->not_title}}</a> a été rétablie pour le cours de <a href="{{ action('CourseController@view', [ 'id' => $not->course_id ]) }}">{{$not->course_title}}</a>

            <span class="notification__time"><?= Carbon::createFromFormat('Y-m-d H:i:s', $not->not_created_at)->diffForHumans(); ?></span>
        </div>

        <div class="notification__actionGroup">
            <a title="Archiver" class="notification__button notification__button--archive icon unlink" href="{!! action( 'NotificationController@archive', [ 'id' => $not->not_id ] ) !!}"><span class="icon-trash"></span><span class="hidden">Archiver</span></a>
        </div>
        <div class="clear"></div>
    </li>
@endif

@if ($not->not_context == 9)	<!-- Séance supprimée -->
    <li class="notification__item notification__color notification__color--red">
        <div class="notification__content">
            La séance du {{$not->not_title}} a été supprimée pour le cours de <a href="{{ action('CourseController@view', [ 'id' => $not->course_id ]) }}">{{$not->course_title}}</a>

            <span class="notification__time"><?= Carbon::createFromFormat('Y-m-d H:i:s', $not->not_created_at)->diffForHumans(); ?></span>
        </div>

        <div class="notification__actionGroup">
            <a title="Archiver" class="notification__button notification__button--archive icon unlink" href="{!! action( 'NotificationController@archive', [ 'id' => $not->not_id ] ) !!}"><span class="icon-trash"></span><span class="hidden">Archiver</span></a>
        </div>
        <div class="clear"></div>
    </li>
@endif

@if ($not->not_context == 10)	<!-- Séance modifiée -->
    <li class="notification__item notification__color notification__color--green">
        <div class="notification__content">
            La séance du <a href="{{ action('SeanceController@view', [ 'id' => $not->seance_id ]) }}">{{$not->not_title}}</a> a été modifiée pour le cours de <a href="{{ action('CourseController@view', [ 'id' => $not->course_id ]) }}">{{$not->course_title}}</a>

            <span class="notification__time"><?= Carbon::createFromFormat('Y-m-d H:i:s', $not->not_created_at)->diffForHumans(); ?></span>
        </div>

        <div class="notification__actionGroup">
            <a title="Archiver" class="notification__button notification__button--archive icon unlink" href="{!! action( 'NotificationController@archive', [ 'id' => $not->not_id ] ) !!}"><span class="icon-trash"></span><span class="hidden">Archiver</span></a>
        </div>
        <div class="clear"></div>
    </li>
@endif

@if ($not->not_context == 11)	<!-- Nouveau Devoir -->
    <li class="notification__item notification__color notification__color--green">
        <div class="notification__content">
            Un nouveau devoir pour la séance du <a href="{{ action('SeanceController@view', [ 'id' => $not->seance_id ]) }}">{{$not->not_title}}</a> du cours de <a href="{{ action('CourseController@view', [ 'id' => $not->course_id ]) }}">{{$not->course_title}}</a>

            <span class="notification__time"><?= Carbon::createFromFormat('Y-m-d H:i:s', $not->not_created_at)->diffForHumans(); ?></span>
        </div>

        <div class="notification__actionGroup">
            <a title="Archiver" class="notification__button notification__button--archive icon unlink" href="{!! action( 'NotificationController@archive', [ 'id' => $not->not_id ] ) !!}"><span class="icon-trash"></span><span class="hidden">Archiver</span></a>
        </div>
        <div class="clear"></div>
    </li>
@endif

@if ($not->not_context == 12)	<!-- Nouveau Test -->
    <li class="notification__item notification__color notification__color--green">
        <div class="notification__content">
            Une nouvelle interrogation pour la séance du <a href="{{ action('SeanceController@view', [ 'id' => $not->seance_id ]) }}">{{$not->not_title}}</a> du cours de <a href="{{ action('CourseController@view', [ 'id' => $not->course_id ]) }}">{{$not->course_title}}</a>

            <span class="notification__time"><?= Carbon::createFromFormat('Y-m-d H:i:s', $not->not_created_at)->diffForHumans(); ?></span>
        </div>

        <div class="notification__actionGroup">
            <a title="Archiver" class="notification__button notification__button--archive icon unlink" href="{!! action( 'NotificationController@archive', [ 'id' => $not->not_id ] ) !!}"><span class="icon-trash"></span><span class="hidden">Archiver</span></a>
        </div>
        <div class="clear"></div>
    </li>
@endif

@if ($not->not_context == 13)	<!-- Devoir Modifié -->
    <li class="notification__item notification__color notification__color--green">
        <div class="notification__content">
            Un devoir a été modifié pour la séance du <a href="{{ action('SeanceController@view', [ 'id' => $not->seance_id ]) }}">{{$not->not_title}}</a> du cours de <a href="{{ action('CourseController@view', [ 'id' => $not->course_id ]) }}">{{$not->course_title}}</a>

            <span class="notification__time"><?= Carbon::createFromFormat('Y-m-d H:i:s', $not->not_created_at)->diffForHumans(); ?></span>
        </div>

        <div class="notification__actionGroup">
            <a title="Archiver" class="notification__button notification__button--archive icon unlink" href="{!! action( 'NotificationController@archive', [ 'id' => $not->not_id ] ) !!}"><span class="icon-trash"></span><span class="hidden">Archiver</span></a>
        </div>
        <div class="clear"></div>
    </li>
@endif

@if ($not->not_context == 14)	<!-- Test Modifié -->
    <li class="notification__item notification__color notification__color--green">
        <div class="notification__content">
            Une interrogation a été modifiée pour la séance du <a href="{{ action('SeanceController@view', [ 'id' => $not->seance_id ]) }}">{{$not->not_title}}</a> du cours de <a href="{{ action('CourseController@view', [ 'id' => $not->course_id ]) }}">{{$not->course_title}}</a>

            <span class="notification__time"><?= Carbon::createFromFormat('Y-m-d H:i:s', $not->not_created_at)->diffForHumans(); ?></span>
        </div>

        <div class="notification__actionGroup">
            <a title="Archiver" class="notification__button notification__button--archive icon unlink" href="{!! action( 'NotificationController@archive', [ 'id' => $not->not_id ] ) !!}"><span class="icon-trash"></span><span class="hidden">Archiver</span></a>
        </div>
        <div class="clear"></div>
    </li>
@endif

@if ($not->not_context == 15)	<!-- Devoir supprimé -->
    <li class="notification__item notification__color notification__color--red">
        <div class="notification__content">
            Un devoir a été supprimé pour la séance du <a href="{{ action('SeanceController@view', [ 'id' => $not->seance_id ]) }}">{{$not->not_title}}</a> du cours de <a href="{{ action('CourseController@view', [ 'id' => $not->course_id ]) }}">{{$not->course_title}}</a>

            <span class="notification__time"><?= Carbon::createFromFormat('Y-m-d H:i:s', $not->not_created_at)->diffForHumans(); ?></span>
        </div>

        <div class="notification__actionGroup">
            <a title="Archiver" class="notification__button notification__button--archive icon unlink" href="{!! action( 'NotificationController@archive', [ 'id' => $not->not_id ] ) !!}"><span class="icon-trash"></span><span class="hidden">Archiver</span></a>
        </div>
        <div class="clear"></div>
    </li>
@endif

@if ($not->not_context == 16)	<!-- Test supprimé -->
    <li class="notification__item notification__color notification__color--red">
        <div class="notification__content">
            Une interrogation a été supprimée pour la séance du <a href="{{ action('SeanceController@view', [ 'id' => $not->seance_id ]) }}">{{$not->not_title}}</a> du cours de <a href="{{ action('CourseController@view', [ 'id' => $not->course_id ]) }}">{{$not->course_title}}</a>

            <span class="notification__time"><?= Carbon::createFromFormat('Y-m-d H:i:s', $not->not_created_at)->diffForHumans(); ?></span>
        </div>

        <div class="notification__actionGroup">
            <a title="Archiver" class="notification__button notification__button--archive icon unlink" href="{!! action( 'NotificationController@archive', [ 'id' => $not->not_id ] ) !!}"><span class="icon-trash"></span><span class="hidden">Archiver</span></a>
        </div>
        <div class="clear"></div>
    </li>
@endif

@if ($not->not_context == 17)	<!-- Cours Supprimé -->
    <li class="notification__item notification__color notification__color--red">
        <div class="notification__content">
            Le cours de {{$not->not_title}} a été supprimé
            <span class="notification__time"><?= Carbon::createFromFormat('Y-m-d H:i:s', $not->not_created_at)->diffForHumans(); ?></span>
        </div>

        <div class="notification__actionGroup">
            <a title="Archiver" class="notification__button notification__button--archive icon unlink" href="{!! action( 'NotificationController@archive', [ 'id' => $not->not_id ] ) !!}"><span class="icon-trash"></span><span class="hidden">Archiver</span></a>
        </div>
        <div class="clear"></div>
    </li>
@endif

@if ($not->not_context == 18)	<!-- Nouveau commentaire -->
    <li class="notification__item notification__color notification__color--green">
        <div class="notification__content">
            Un commentaire a été ajouté pour la séance du <a href="{{ action('SeanceController@view', [ 'id' => $not->seance_id ]) }}">{{$not->not_title}}</a> du cours de <a href="{{ action('CourseController@view', [ 'id' => $not->course_id ]) }}">{{$not->course_title}}</a>

            <span class="notification__time"><?= Carbon::createFromFormat('Y-m-d H:i:s', $not->not_created_at)->diffForHumans(); ?></span>
        </div>

        <div class="notification__actionGroup">
            <a title="Archiver" class="notification__button notification__button--archive icon unlink" href="{!! action( 'NotificationController@archive', [ 'id' => $not->not_id ] ) !!}"><span class="icon-trash"></span><span class="hidden">Archiver</span></a>
        </div>
        <div class="clear"></div>
    </li>
@endif