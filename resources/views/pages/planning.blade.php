<?php
use Carbon\Carbon;
use App\Course;
use App\User;
use App\Comment;
setlocale( LC_ALL, 'fr_FR.UTF-8');
?>

@extends('layout')
@section('title', $title)
@section('content')

<?php
    // Récuperation des variables passées, on donne soit année; mois; année+mois
    if(!isset($_GET['mois'])) $num_mois = date("n"); else $num_mois = $_GET['mois'];
    if(!isset($_GET['annee'])) $num_an = date("Y"); else $num_an = $_GET['annee'];

    // pour pas s'embeter a les calculer a l'affchage des fleches de navigation...
    if($num_mois < 1) { $num_mois = 12; $num_an = $num_an - 1; }
    elseif($num_mois > 12) {	$num_mois = 1; $num_an = $num_an + 1; }

    // nombre de jours dans le mois et numero du premier jour du mois
    $int_nbj = date("t", mktime(0,0,0,$num_mois,1,$num_an));
    $int_premj = date("w",mktime(0,0,0,$num_mois,1,$num_an));

    // tableau des jours, tableau des mois...
    $tab_jours = array("","Lun","Mar","Mer","Jeu","Ven","Sam","Dim");
    $tab_mois = array("","Janvier","Fevrier","Mars","Avril","Mai","Juin","Juillet","Aout","Septembre","Octobre","Novembre","Decembre");

    $int_nbjAV = date("t", mktime(0,0,0,($num_mois-1<1)?12:$num_mois-1,1,$num_an)); // nb de jours du moi d'avant
    $int_nbjAP = date("t", mktime(0,0,0,($num_mois+1>12)?1:$num_mois+1,1,$num_an)); // b de jours du mois d'apres

    // on affiche les jours du mois et aussi les jours du mois avant/apres, on les indique par une * a l'affichage on modifie l'apparence des chiffres *
    $tab_cal = array(array(),array(),array(),array(),array(),array()); // tab_cal[Semaine][Jour de la semaine]
    $int_premj = ($int_premj == 0)?7:$int_premj;
    $t = 1; $p = "";
    for($i=0;$i<6;$i++) {
        for($j=0;$j<7;$j++) {
            if($j+1 == $int_premj && $t == 1) { $tab_cal[$i][$j] = $t; $t++; } // on stocke le premier jour du mois
            elseif($t > 1 && $t <= $int_nbj) { $tab_cal[$i][$j] = $p.$t; $t++; } // on incremente a chaque fois...
            elseif($t > $int_nbj) { $p="**"; $tab_cal[$i][$j] = $p."1"; $t = 2; } // on a mis tout les numeros de ce mois, on commence a mettre ceux du suivant
            elseif($t == 1) { $tab_cal[$i][$j] = "*".($int_nbjAV-($int_premj-($j+1))+1); } // on a pas encore mis les num du mois, on met ceux de celui d'avant
        }
    }
?>


    <div class="blockTitle">
        <a class="calendar__controller calendar__controller--before calendar__controller--before--month unlink" href="?mois=<?php echo $num_mois-1; ?>&amp;annee=<?php echo $num_an; ?>"><span class="calendar__arrow"></span></a>
        <h2 class="hidden">Mon planning de {{ $tab_mois[$num_mois] }} {{ $num_an }}</h2>
        <p class="mainTitle">
            <?php echo $tab_mois[$num_mois];  ?>
        </p>
        <p class="subTitle">
            <?php echo $num_an;  ?>
        </p>
        <a class="calendar__controller calendar__controller--after calendar__controller--after--month unlink" href="?mois=<?php echo $num_mois+1; ?>&amp;annee=<?php echo $num_an; ?>"><span class="calendar__arrow"></span></a>
    </div>

    <!-- dd_moreButton -->
    @if( Auth::user()->status == 1 )
        <div class="dd_moreButton">
            <input type="checkbox" id="dd_moreButton">
            <label for="dd_moreButton" class="dd_moreButton--button"><span></span><span></span></label>

            <ul class="dd_moreButton--content">
                <li><a href="{!! action( 'CourseController@create' ) !!}">Créer un cours…</a></li>
            </ul>
        </div>
    @endif

    <div class="whiteBanner whiteBanner--calendar">
        <a class="calendar__controller calendar__controller--before calendar__controller--before--month unlink" href="?mois=<?php echo $num_mois-1; ?>&amp;annee=<?php echo $num_an; ?>"><span class="calendar__arrow"></span></a>
        <table class="calendar__box">
            <tr>
            @for( $i = 1; $i <= 7; $i++ ) <!-- TABLE TITLE -->
                <th class="caldendar_box--title">{{ $tab_jours[$i] }}</th>
            @endfor
            </tr>

            @for( $i = 0; $i < 6; $i++ )
                <tr>
                    @for( $j = 0; $j < 7; $j++ )
                    <?php
                        $mois_actif = $num_mois;

                        if ( (strpos($tab_cal[$i][$j],"*") !== false )) {
                            $mois_actif = $num_mois-1;
                        }
                        if ( (strpos($tab_cal[$i][$j],"**") !== false )) {
                            $mois_actif = $num_mois+1;
                        }

                        // Get the activ day
                        $actifDay = $tab_cal[$i][$j];
                        $actifDayCorrect = str_replace("*","",$tab_cal[$i][$j]);
                        $actifMonth = $num_mois;
                        $previousMonth = $num_mois-1;
                        $nextMonth = $num_mois+1;
                        $actifYear = $num_an;
                        if( strlen($actifDay) == 1){ $actifDay = '0'.$actifDay; };
                        if( strlen($actifDayCorrect) == 1){ $actifDayCorrect = '0'.$actifDayCorrect; };
                        if( strlen($actifMonth) == 1){ $actifMonth = '0'.$actifMonth; };
                        if( strlen($previousMonth) == 1){ $previousMonth = '0'.$previousMonth; };
                        if( strlen($nextMonth) == 1){ $nextMonth = '0'.$nextMonth; };

                        $defineActiveDay = '';
                        if (($actifYear.'-'.$actifMonth.'-'.$actifDay) == $the_active_day) {
                            $defineActiveDay = 'active_day ';
                        }

                        $hasASeance = '';
                        // Show when there is a seance in the current month
                        if ( in_array( ($actifYear.'-'.$actifMonth.'-'.$actifDay), $allSeances ) ) {
                            $hasASeance = 'has_a_seance ';
                        }
                        if ( ( substr( $actifDay, 0, 1 ) == "*" ) && ( substr( $actifDay, 1, 1 ) != "*" ) ) {
                            // Show when there is a seance in the previous month
                            if ( in_array( ($actifYear.'-'.$previousMonth.'-'.$actifDayCorrect), $allSeances ) ) {
                                $hasASeance = 'has_a_seance ';
                            }
                        }
                        if ( substr( $actifDay, 0, 2 ) == "**" ) {
                            // Show when there is a seance in the next month
                            if ( in_array( ($actifYear.'-'.$nextMonth.'-'.$actifDayCorrect), $allSeances ) ) {
                                $hasASeance = 'has_a_seance ';
                            }
                        }

                        $isToday = '';
                        if ( $num_mois == date("n") && $num_an == date("Y") && $tab_cal[$i][$j] == date("j") )
                        {
                            $isToday = 'today ';
                        }
                    ?>
                    <td>
                        <a href="?jour={{ str_replace("*","",$tab_cal[$i][$j]) }}&mois={{ $mois_actif }}&annee={{ $num_an }}" class="{{ $defineActiveDay }} {{ $isToday }} @if( strpos( $tab_cal[$i][$j],"*" ) !== false ) otherMonth @endif">

                            <span>
                                @if( strpos( $tab_cal[$i][$j],"*" ) !== false )
                                    {{ str_replace("*","",$tab_cal[$i][$j]) }}
                                @else
                                    {{ $tab_cal[$i][$j] }}
                                @endif
                            </span>
                            <span class="{{ $hasASeance }}"></span>
                        </a>
                    </td>
                    @endfor
                </tr>
            @endfor
        </table>
        <a class="calendar__controller calendar__controller--after calendar__controller--after--month unlink" href="?mois=<?php echo $num_mois+1; ?>&amp;annee=<?php echo $num_an; ?>"><span class="calendar__arrow"></span></a>
    </div>


    <ul class="box--group">
        @if( empty( $currentSeances ) )
            <li class="calendar__empty" >Aucune séance prévue à cette date</li>
        @else
            <?php $pos = 1; ?>
        @foreach( $currentSeances as $seance )
            <li class="box box--demis box--demis--continue box--shadow box--seance--calendar {{ $pos%2 ? 'odd' : 'even' }} @if( $seance->absent == 1 ) course__absenceSeance @endif @if( \Auth::user()->status == 1 ) teacher @endif">
                <div class="box__group--list seance__group--list">
                    <div class="box__group--list--list box__seanceCourse">
                        <div class="box__head box__blockTitle box__blockTitle--dark box__head--calendar">
                            <h3>Cours de {{ $seance->course->title }} (&#8239;{{ $seance->course->group }}&#8239;)</h3>
                            <h4>Le {{ $seance->start_hours->formatLocalized('%d-%m-%Y') }} de {{ $seance->start_hours->formatLocalized('%Hh%M') }} à {{ $seance->end_hours->formatLocalized('%Hh%M') }}</h4>
                            @if( Auth::user()->status == 1 )
                                <div class="boxTitle__teahcerIcon--group">
                                    <a title="Modifier" class="icon icon-note unlink boxTitle__editIcon boxTitle__teacherIcon" href="{!! action( 'SeanceController@edit', [ "id" => $seance->id ] ) !!}">
                                        <span class="hidden">modifier</span>
                                    </a>
                                    <a title="Supprimer" data-page="planning" class="action__deleteSeance icon icon-trash unlink boxTitle__deleteIcon boxTitle__teacherIcon" href="{!! action( 'SeanceController@delete', [ "id" => $seance->id ] ) !!}">
                                        <span class="hidden">Supprimer</span>
                                    </a>
                                </div>
                            @endif
                            <div class="clear"></div>
                        </div>
                        <div class="box__conent box__content-calendar">
                        <a class="box__seanceDate" href="{!! action( 'SeanceController@view', ['id' => $seance->id] ) !!}">
                            <span class="box__seanceDate--day">{{ $seance->start_hours->formatLocalized('%A') }}</span>
                            <span class="box__seanceDate--dayNumber">{{ $seance->start_hours->formatLocalized('%d') }}</span>
                            <span class="box__seanceDate--month">{{ $seance->start_hours->formatLocalized('%B') }}</span>
                            <span class="box__highlight box__seanceDate--hour">{{ $seance->start_hours->formatLocalized('%Hh%M') }}</span>
                        </a>
                        <div class="box__seanceCourse--info">
                            <!-- HOMEWORKS -->
                            <a href="{!! action( 'SeanceController@view', ['id' => $seance->id] ) !!}#works" class="box__seanceCourse--homework box__seanceCourse--numbers">
                                <span class="icon-briefcase"></span>
                                @if( count($seance->works) !== 0 )
                                    Devoirs&#8239;: {{ count($seance->works) }}
                                @else
                                    Devoirs&#8239;: 0
                                @endif
                            </a>

                            <!-- TESTS -->
                            <a href="{!! action( 'SeanceController@view', ['id' => $seance->id] ) !!}#tests" class="box__seanceCourse--test box__seanceCourse--numbers">
                                <span class="icon-book-open"></span>
                                @if( count($seance->tests) !== 0 )
                                    Tests&#8239;: {{ count($seance->tests) }}
                                @else
                                    Tests&#8239;: 0
                                @endif
                            </a>

                            <!-- COMMENTS -->
                            <a href="{!! action( 'SeanceController@view', ['id' => $seance->id] ) !!}#comments" class="box__seanceCourse--comment box__seanceCourse--numbers">
                                <span class="icon-bubbles"></span>
                                <?php $theSeanceComment = []; ?>
                                @foreach( $comments as $comment )
                                    @if( $comment->for == $seance->id )
                                        <?php $theSeanceComment[] = $comment; ?>
                                    @endif
                                @endforeach
                                @if( !empty($theSeanceComment) )
                                    Com&#8239;: {{ count($theSeanceComment) }}
                                @else
                                    Com&#8239;: 0
                                @endif

                            </a>
                        </div>
                        <div class="clear"></div>
                    </div>
                </div>
            </li>
            <?php $pos++; ?>
        @endforeach
        @endif
    </ul>


@endsection
