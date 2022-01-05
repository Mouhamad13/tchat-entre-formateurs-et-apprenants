<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Course;
use App\Seance;
use App\Comment;
use App\Work;
use App\Test;
use App\User;
use Carbon\Carbon;
use DB;

class CalendarController extends Controller
{
    public function view() 
    {
        $title = "Mon planning • ISEP";
        $activePage = 'planning';
        Carbon::setLocale('fr');

        if( isset($_GET['jour']) ) {
            $day = $_GET['jour'];
            $month = $_GET['mois'];
            $year = $_GET['annee'];
        } else {
            $day = Carbon::today()->day;
            $month = Carbon::today()->month;
            $year = Carbon::today()->year;
        }
        // Add 0 before a single number
        if( strlen($day) == 1){ $day = '0'.$day; };
        if( strlen($month) == 1){ $month = '0'.$month; };
        // Add 0 before a single number >
        $the_active_day = $year.'-'.$month.'-'.$day;

        $comments = Comment::where('context', '=', 1)->get();

        if (\Auth::user()->status == 1) { // IF TEACHER
            $courses = Course::where('teacher_id', '=', \Auth::user()->id)->get();
            $seances = [];
            $allSeances = [];
            $currentSeances = [];
            foreach ( $courses as $course ) {
                $seances[] = $course->seances->sortBy('start_hours');
            }
            foreach ($seances as $seance) {
                foreach ($seance as $the_seance) {
                    if( $the_seance->start_hours->formatLocalized('%Y-%m-%d') == $the_active_day) {
                        $currentSeances[] = $the_seance;
                    }
                    $allSeances[] = $the_seance->start_hours->formatLocalized('%Y-%m-%d');
                }
            }
        } else { // IF STUDENT
            $allCourses = $courses = User::find(\Auth::user()->id)->courses;
            $courses = [];
            foreach ($allCourses as $singleCourse) {
                if ( $singleCourse->pivot->access == 2 ) {
                    $courses[] = $singleCourse;
                }
            }
            $seances = [];
            $allSeances = [];
            $currentSeances = [];
            foreach ( $courses as $course ) {
                $seances[] = $course->seances->sortBy('start_hours');
            }
            foreach ($seances as $seance) {
                foreach ($seance as $the_seance) {
                    if( $the_seance->start_hours->formatLocalized('%Y-%m-%d') == $the_active_day) {
                        $currentSeances[] = $the_seance;
                    }
                    $allSeances[] = $the_seance->start_hours->formatLocalized('%Y-%m-%d');
                }
            }
        }

        return view('pages/planning', compact( 'title', 'activePage', 'day', 'month', 'year', 'allSeances', 'comments', 'currentSeances', 'the_active_day' ));
    }
}
