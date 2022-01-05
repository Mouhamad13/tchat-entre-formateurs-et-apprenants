<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use \Input;
use Validator;

use App\Notification;
use App\Course;
use App\Seance;
use App\Work;
use App\Test;
use App\Comment;
use Carbon\Carbon;

class SeanceController extends Controller
{

    protected $storeRules = [
        'start_date' => 'required|date',
        'end_date' => 'required|date|after:start_date',
        'start_hours' => 'required|date_format:H:i',
        'end_hours' => 'required|date_format:H:i|after:start_hours'
        ];

    protected $updateRules = [
        'date' => 'required|date',
        'start_hours' => 'required|date_format:H:i',
        'end_hours' => 'required|date_format:H:i|after:start_hours'
        ];

    public function create( $id ) {
        $title = 'Générer des séances • ISEP';
        $activePage = 'course';
        $courses = Course::where( 'teacher_id', '=', \Auth::user()->id )->get();
        $days = [
            "monday" => "lundi",
            "tuesday" => "mardi",
            "wednesday" => "mercredi",
            "thursday" => "jeudi",
            "friday" => "vendredi",
            "saturday" => "samedi",
            "sunday" => "dimanche"
        ];
        $today = Carbon::now()->format('d-m-Y');
        $tomorrow = Carbon::tomorrow()->format('d-m-Y');
        return view('seance/createSeance', compact('title', 'id', 'courses', 'days', 'today', 'tomorrow', 'activePage'));
    }

    public function store() {
        $error = Validator::make(Input::all(), $this->storeRules);
        if ($error->fails()) {
            return redirect()->back()->withErrors($error);
        }

        $day = Input::get('date').' '.Input::get('daypicker');
        $start_hours = Input::get('date').' '.Input::get('start_hours');
        $end_hours = Input::get('date').' '.Input::get('end_hours');
        $obj_dateStart = date_create($_POST['start_date']  . ' -1 day');
        $obj_dateEnd = date_create($_POST['end_date']);
        while ($obj_dateStart->format('U') <= $obj_dateEnd->format('U')) {
            $obj_dateStart->modify('next '.$day);
            if ($obj_dateStart->format('U') <= $obj_dateEnd->format('U')) {
                $seance = Seance::create([
                    'course_id' => Input::get('course'),
                    'start_hours' => $obj_dateStart->format('Y-m-d').$start_hours.':00',
                    'end_hours' => $obj_dateStart->format('Y-m-d').$end_hours.':00',
                    'local' => Input::get('local')
                ]);
            }
        }

        $course = Course::findOrFail( Input::get('course') );

        $students = \DB::table('course_user')
            ->where('course_id', $course->id)->get();

        if( !empty($students) ) {
            foreach( $students as $student ) {
                Notification::create([
                    'title' => $course->title,  // NEW SEANCES TO A COURSE
                    'course_id' => $course->id,
                    'user_id' => \Auth::user()->id,
                    'context' => 6,
                    'seen' => 0,
                    'for' => $student->user_id
                ]);
            }
        }

        return redirect()->route('viewCourse', ['id' => Input::get('course'), 'action' => 1]);
    }


    public function edit( $id ) {
        $seance = Seance::findOrFail($id);
        $days = [
            "monday" => "lundi",
            "tuesday" => "mardi",
            "wednesday" => "mercredi",
            "thursday" => "jeudi",
            "friday" => "vendredi",
            "saturday" => "samedi",
            "sunday" => "dimanche"
        ];
        $title = 'Modifier la séance • ISEP';
        $activePage = 'course';
        $courses = Course::where( 'teacher_id', '=', \Auth::user()->id )->get();
        $course_id = $seance->course_id;

        $local = $seance->local;

        $start_day = $seance->start_hours->formatLocalized('%d-%m-%Y');
        $end_day = $seance->end_hours->formatLocalized('%d-%m-%Y');
        $start_hours = $seance->start_hours->formatLocalized('%H:%M');
        $end_hours = $seance->end_hours->formatLocalized('%H:%M');

        return view('seance/updateSeance', compact('title', 'seance', 'days', 'id', 'courses', 'course_id', 'start_day', 'end_day', 'start_hours', 'end_hours', 'local', 'activePage'));
    }

    public function update( $id ) {
        $error = Validator::make(Input::all(), $this->updateRules);
        if ($error->fails()) {
            return redirect()->back()->withErrors($error);
        }
        $seance = Seance::findOrFail($id);
        $day = Carbon::createFromFormat('d-m-Y', Input::get('date'));
        $start_hours = Input::get('start_hours');
        $end_hours = Input::get('end_hours');

        $seance->course_id = Input::get('course');
        $seance->start_hours = $day->formatLocalized('%Y-%m-%d').' '.$start_hours.':00';
        $seance->end_hours = $day->formatLocalized('%Y-%m-%d').' '.$end_hours.':00';
        $seance->local = Input::get('local');

        $course = $seance->course;

        $students = \DB::table('course_user')
            ->where('course_id', $course->id)->get();

        if( !empty($students) ) {
            foreach( $students as $student ) {
                setlocale( LC_ALL, 'fr_FR.UTF-8');
                Notification::create([
                    // Séance supprimée
                    'title' => $seance->start_hours->formatLocalized('%d %B %Y'),
                    'course_id' => $course->id,
                    'seance_id' => $seance->id,
                    'user_id' => \Auth::user()->id,
                    'context' => 10,
                    'seen' => 0,
                    'for' => $student->user_id
                ]);
            }
        }


        $seance->save();
        return redirect()->route('viewSeance', ['id' => $id]);
    }

    public function view( $id ) {
        setlocale( LC_ALL, 'fr_FR.UTF-8');
        $seance = Seance::findOrFail($id);

        $course = Course::findOrFail($seance->course_id);
        if( \Auth::user()->status == 1 AND \Auth::user()->id != $course->teacher_id ) {
            return redirect()->route('home', ['popupError' => "userAccess"]);
        }

        $datetime1 = new Carbon( $seance->start_hours );
        $datetime2 = new Carbon($seance->end_hours);
        $interval = $datetime1->diff($datetime2);

        $comments = Comment::where('context', '=', 1)->where('for', $id)->get();
        $title = 'Séance du '.$seance->start_hours->formatLocalized('%A %d %B %Y') . ' de ' . $seance->start_hours->formatLocalized('%Hh%M') . ' à ' . $seance->end_hours->formatLocalized('%Hh%M').' • Stucher';
        $activePage = 'course';



        // Check if user has access
            $students = Course::find($seance->course->id)->users;
            $inCourseStudents = [];
            $demandedStudents = [];
            $inCourseStudentsId = [];
            $demandedStudentsId = [];
            foreach ($students as $student) {
                if( $student->pivot->access == 1 ){
                    $demandedStudents[] = $student;
                    $demandedStudentsId[] = $student->id;
                }
                if( $student->pivot->access == 2 ){
                    $inCourseStudents[] = $student;
                    $inCourseStudentsId[] = $student->id;
                }
            }

            $the_user = 'not';
            if (in_array(\Auth::user()->id, $inCourseStudentsId)) {
                $the_user = 'valided';
            }
            elseif (in_array(\Auth::user()->id, $demandedStudentsId)) {
                $the_user = 'demanded';
            }
            if ( \Auth::user()->status != 1 ) {
                if ( $the_user == 'demanded' ) {
                    return redirect()->route('home', ['popupError' => 'userAccess']);
                }
            }

        return view('seance/viewSeance', compact( 'title', 'id', 'seance', 'interval', 'comments', 'activePage' ));
    }

    public function all( $id ) {
        setlocale( LC_ALL, 'fr_FR.UTF-8');
        $now = Carbon::now()->format('Y-m-d H:i:s');
        $course = Course::findOrFail( $id );
        if( \Auth::user()->status == 1 AND \Auth::user()->id != $course->teacher_id ) {
            return redirect()->route('home', ['popupError' => "userAccess"]);
        }
        $comments = Comment::where('context', '=', 1)->get();
        $seances = Seance::where( 'course_id', '=', $id )->where( 'end_hours', '>', $now )->paginate(10);
        $title = "Toutes les séances du cours de ".$course->title.' • Stucher';
        $activePage = 'course';

        return view('seance/seancesList', compact( 'title', 'seances', 'comments', 'course', 'activePage'));
    }

    public function getByCourse( $id_course ) {
        return Course::find($id_course)->seances;
    }

    public function delete( $id ) {
        $seance = Seance::findOrFail($id);
        $course = Course::findOrFail($seance->course_id);

        $students = \DB::table('course_user')
            ->where('course_id', $course->id)->get();

        if( !empty($students) ) {
            foreach( $students as $student ) {
                setlocale( LC_ALL, 'fr_FR.UTF-8');
                Notification::create([
                    // Séance supprimée
                    'title' => $seance->start_hours->formatLocalized('%d %B %Y'),
                    'course_id' => $course->id,
                    'seance_id' => $seance->id,
                    'user_id' => \Auth::user()->id,
                    'context' => 9,
                    'seen' => 0,
                    'for' => $student->user_id
                ]);
            }
        }

        $works = Work::where( 'seance_id', '=', $id )->get();
        foreach ($works as $work) {
            $work->delete();   
        }

        $tests = Test::where( 'seance_id', '=', $id )->get();
        foreach ($tests as $test) {
            $test->delete();   
        }

        $comments = Comment::where( 'for', '=', $seance->id )->get();
        foreach ($comments as $comment) {
            $comment->delete();
        }

        $seance->delete();
        return redirect()->route('viewCourse', ['id' => $course->id, 'action' => 1]);
    }

    public function deleteAll( $course ) {
        $seances = Seance::where( 'course_id', '=', $course )->get();
        foreach ($seances as $seance) {
            $works = Work::where( 'seance_id', '=', $seance->id )->get();
            foreach ($works as $work) {
                $work->delete();   
            }

            $tests = Test::where( 'seance_id', '=', $seance->id )->get();
            foreach ($tests as $test) {
                $test->delete();   
            }

            $seance->delete();   
        }
        return redirect()->route('viewCourse', ['id' => $course, 'action' => 1]);
    }

    public function seanceHistory( $id ) 
    {
        setlocale( LC_ALL, 'fr_FR.UTF-8');
        $now = Carbon::now()->format('Y-m-d H:i:s');
        $course = Course::findOrFail( $id );
        if( \Auth::user()->status == 1 AND \Auth::user()->id != $course->teacher_id ) {
            return redirect()->route('home', ['popupError' => "userAccess"]);
        }
        $comments = Comment::where('context', '=', 1)->get();
        $seances = Seance::where( 'course_id', '=', $id )->where( 'end_hours', '<', $now )->orderBy('start_hours','desc')->paginate(10);
        $title = "Les séances terminées du cours de ".$course->title." • ISEP";
        $activePage = 'course';

        return view('seance/seancesHistory', compact( 'title', 'seances', 'comments', 'course', 'activePage'));
    }

    public function absent( $id )
    {
        $seance = Seance::findOrFail($id);
        $seance->absent == 1 ? $seance->absent = 0 : $seance->absent = 1;
        $seance->save();

        $course = $seance->course;

        $students = \DB::table('course_user')
            ->where('course_id', $course->id)->get();

        if( !empty($students) ) {
            foreach( $students as $student ) {
                setlocale( LC_ALL, 'fr_FR.UTF-8');
                if( $seance->absent == 1 ) {
                    Notification::create([
                        // Séance annulé (absence)
                        'title' => $seance->start_hours->formatLocalized('%d %B %Y'),
                        'course_id' => $course->id,
                        'seance_id' => $seance->id,
                        'user_id' => \Auth::user()->id,
                        'context' => 7,
                        'seen' => 0,
                        'for' => $student->user_id
                    ]);
                } else {
                    Notification::create([
                        // Séance annulé (absence)
                        'title' => $seance->start_hours->formatLocalized('%d %B %Y'),
                        'course_id' => $course->id,
                        'seance_id' => $seance->id,
                        'user_id' => \Auth::user()->id,
                        'context' => 8,
                        'seen' => 0,
                        'for' => $student->user_id
                    ]);
                }
            }
        }

        return redirect()->back();
    }
}
