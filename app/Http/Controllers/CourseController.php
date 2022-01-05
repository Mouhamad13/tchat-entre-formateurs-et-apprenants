<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Course;
use App\User;
use App\Seance;
use App\Comment;
use App\Work;
use App\Test;
use \Input;
use App\Notification;
use Carbon\Carbon;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class CourseController extends Controller
{

    protected $rules = [
        'title' => 'required|max:255',
        'group' => 'required|max:255',
        'school' => 'required|max:255',
        'place' => 'required|max:255'
        ];

    protected $searchRules = [
        'search' => 'required',
        'type' => 'required'
    ];

    public function index() {
        $title = 'ISEP-JOURNAL-DE-CLASSE';

        if ( \Auth::check() ) {
            $title = 'Tous mes cours • ISEP';
            $activePage = 'course';
            if ( \Auth::user()->status == 1 ) {
                $courses = Course::where( 'teacher_id', '=', \Auth::user()->id )->get();
                return view('courses/indexTeacherCourses', compact('courses', 'title', 'activePage'));
            } else 
            {
                $courses = User::find(\Auth::user()->id)->courses;
                $waitCourses = [];
                foreach( $courses as $course ) {
                    if( $course->pivot->access == 1 ) {
                        $waitCourses[] = $course;
                    }
                }

                $teachers = User::all();

                return view('courses/indexStudentCourses', compact('courses', 'waitCourses', 'title', 'activePage', 'teachers'));
            }
        } 
        return view('welcome', compact('title'));
    }

    public function view( $id ) {
        setlocale( LC_ALL, 'fr_FR.UTF-8');
        $course = Course::findOrFail($id);
        $teacher = User::where( 'id', '=', $course->teacher_id )->get();
        if( \Auth::user()->status == 1 AND \Auth::user()->id != $course->teacher_id ) {
            return redirect()->route('home', ['popupError' => "userAccess"]);
        }
        $now = Carbon::now()->format('Y-m-d H:i:s');
        $allSeances = $course->seances->sortBy('start_hours');
        $fiveSeances = $course->seances->sortBy('start_hours')->take(5);
        $seances = [];
        $fiveSeance = [];
        $comments = Comment::where('context', '=', 1)->get();
        $title = 'Cours de '.$course->title.' • ISEP';
        $activePage = 'course';
        foreach( $allSeances as $theSeance ) {
            if( $theSeance->start_hours > $now ) {
                $seances[] = $theSeance;
            }
        }
        foreach( $fiveSeances as $theSeance ) {
            if( $theSeance->start_hours > $now ) {
                $fiveSeances[] = $theSeance;
            }
        }

        // Check if user has acces
            $students = Course::find($id)->users;

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
                    return view('courses/waitCourse', compact('title', 'course', 'activePage'));
                }
            }

        if ( \Auth::user()->status == 1 ) {
            $title = 'Cours de '.$course->title.' • ISEP';

            return view('courses/viewCourse', compact('id', 'course', 'title', 'seances', 'comments', 'fiveSeances', 'allSeances', 'demandedStudents', 'inCourseStudents', 'demandedStudentsId', 'inCourseStudentsId', 'activePage'));
        }

        return view('courses/viewCourse', compact('course', 'teacher', 'title', 'seances', 'comments', 'fiveSeances', 'allSeances', 'inCourseStudents', 'demandedStudentsId', 'inCourseStudentsId', 'activePage'));
    }

    public function create() {
        $title = 'Créer un cours • ISEP';
        $activePage = 'course';
        return view('courses/createCourse', ['title' => $title, 'activePage' => $activePage]);
    }

    public function store() {
        $errors = Validator::make(Input::all(), $this->rules);
        if ($errors->fails()) {
            return Redirect()->back()->withErrors($errors);
        }
        $courses = Course::all();
        $course = Course::create([
            'title' => Input::get('title'),
            'teacher_id' => \Auth::user()->id,
            'access_token' => substr( md5(Carbon::now() ), 0, 6),
            'group' => Input::get('group'),
            'school' => Input::get('school'),
            'place' => Input::get('place'),
            ]);
        
        return redirect()->route('home');
    }
    public function updatePicture()
    {
        if( !Input::file('image') )
        {
            return Redirect()->back()->withErrors('Veuillez entrez un fichier');
        } else
        {
            $image = Input::file('image');
            $typeMime = explode( '/' , $image->getMimeType() );
            if ( $typeMime[1] == 'jpeg' OR $typeMime[1] == 'gif' OR $typeMime[1] == 'png' )
            {
                Input::file('image')->getMimeType();
                if ( \Auth::user()->image != "default.jpg" )
                {
                    File::delete( public_path( 'img/profilPicture/' . \Auth::user()->image ) );
                }
                $imageName = $image->getClientOriginalName();
                $nameParts = explode('.', $imageName);
                $ext = strtolower(end($nameParts));
                $newname = md5( $imageName . time() ) . '.' . $ext;
                $path = public_path('img/profilPicture/' . $newname);
                $newImage = Image::make($image->getRealPath());
                $newImage->fit(360, 360, function ($constraint) {
                    $constraint->upsize();
                });
                $newImage->save($path);
                \Auth::user()->image = $newname;
                \Auth::user()->save();
            } else
            {
                return Redirect()->back()->withErrors('Veuillez choisir un bon format d’image (jpeg, png ou gif)');
            }
        }
        return redirect()->route('about');
    }

    public function searchCourse() {
        if ( \Auth::check() && \Auth::user()->status==2 ) {
            //$coursesIds = \Auth::user()->courses->lists('id');
            $title = 'Rechercher un cours • ISEP';
            $activePage = 'course';
            //$courses = Course::whereNotIn('id',$coursesIds)->get();
            $courses = null;
            $users = null;
            //$users = User::all();

            return view('courses/indexAllCourses', compact('courses', 'users', 'title', 'activePage'));
        }
        return back();
    }

    public function searchCourseResult() {
        $errors = Validator::make(Input::all(), $this->searchRules);
        if ($errors->fails()) {
            return Redirect()->back()->withErrors($errors);
        }
        $search_input = Input::get('search');
        $type = Input::get('type');
        $title = 'Rechercher un cours • ISEP';
        $activePage = 'course';

        ////////// IF SEARCH
        $id_courses = [];

        if( $type == 'search' ) {
            $myCourses = \DB::table('course_user')->where('user_id', \Auth::user()->id)->get();
            $myCoursesID = [];

            foreach ($myCourses as $myCourse) {
                $myCoursesID[] = $myCourse->course_id;
            }

            $users = User::all();
            $courses = Course::where('title', 'LIKE', '%' . $search_input . '%')
                ->orWhere('group', 'LIKE', '%' . $search_input . '%')
                ->orWhere('school', 'LIKE', '%' . $search_input . '%')
                ->orWhere('place', 'LIKE', '%' . $search_input . '%')
                ->get();

            foreach( $courses as $search_course ) {
                $id_courses[] = $search_course->id;
            }

            $search_teacher = User::where( 'status', '1' )
                ->where('firstname', 'LIKE', '%' . $search_input . '%')
                ->orWhere('name', 'LIKE', '%' . $search_input . '%')
                ->get();

            if( empty( $search_teacher[0] ) ) {
            } else {
                foreach( $search_teacher as $teacher ) {
                    $courses_teacher = Course::where( 'teacher_id', $teacher->id )->get();
                    foreach( $courses_teacher as $course_teacher ) {
                        if( !in_array( $course_teacher->id, $id_courses ) ) {
                            $id_courses[] = $course_teacher->id;
                            $courses[] = $course_teacher;
                        }
                    }
                }
            }

            return view('courses/indexAllCourses', compact('courses', 'myCoursesID', 'users', 'search_input', 'title', 'activePage'));
        }




        ////////// IF TOKEN
        if( $type == 'access' ) {
            $errors = null;
            $access_course = Course::where( 'access_token', '=', $search_input )->first();
            // Check if user has already access
            if( $access_course == null ) {
                // Aucun COURS
                $errors = 'Ce code est non valide';
            } else if( empty( $access_course->users) ) {
                // premier élève à suivre le cours

                // Check if the demande exist
                if( !empty( \DB::table('course_user')->where('user_id', \Auth::user()->id)->where('course_id', $access_course->id)->get() ) ) {
                    return back()->withErrors( 'Vous avez déjà demandé accès à ce cours' );
                }
            } else {
                foreach( $access_course->users as $user ) {
                    if( $user->pivot->course_id == $access_course->id ) {
                        // L'utilisateur est déjà inscrit à ce cours
                        return redirect()->route('viewCourse', ['id' => $access_course->id]);
                    }
                }
            }

            if ( $errors == null ) {
                $student = User::findOrFail(\Auth::user()->id);

                // Ajouter le cours et l'utilisateur à la table course_user
                $student->courses()->attach( $access_course );
                \DB::table('course_user')
                    ->where('user_id', \Auth::user()->id)->where('course_id', $access_course->id)
                    ->update(array('access' => 1));

                Notification::create([
                    'title' => 'demande accès au cours de',
                    'course_id' => $access_course->id,
                    'user_id' => \Auth::user()->id,
                    'context' => 1,
                    'seen' => 0,    // ACTIONS => with buttons
                    'for' => Course::where('id', $access_course->id)->get()->first()->teacher_id
                ]);

                return redirect()->route('home');
            } else {
                return redirect()->back()->withErrors($errors);
            }

        }


    }

    public function addCourse( $id ) {
        if ( \Auth::check() && \Auth::user()->status==2 ) {
            $student = User::findOrFail(\Auth::user()->id);

            if( !empty( \DB::table('course_user')->where('user_id', \Auth::user()->id)->where('course_id', $id)->get() ) ) {
                return back()->withErrors( 'Vous avez déjà demandé accès à ce cours' );
            }

            // Ajouter le cours et l'utilisateur à la table course_user
            $student->courses()->attach( $id );
            \DB::table('course_user')
                ->where('user_id', \Auth::user()->id)->where('course_id', $id)
                ->update(array('access' => 1));

            Notification::create([
                'title' => 'demande accès au cours de',
                'course_id' => $id,
                'user_id' => \Auth::user()->id,
                'context' => 1, // DEMANDE D'ACCES
                'seen' => 0,    // ACTIONS => with buttons
                'for' => Course::where('id', $id)->get()->first()->teacher_id
            ]);
            
            return redirect()->route('home');
        } 
        return back();
    }

    public function waitCourse() {
        $title = 'Cours en attente de validation • ISEP';
        $activePage = 'course';
        $courses = User::find(\Auth::user()->id)->courses;
        $waitCourses = [];
        foreach( $courses as $course ) {
            if( $course->pivot->access == 1 ) {
                $waitCourses[] = $course;
            }
        }
        return view('courses/indexWaitingCourses', compact('courses', 'waitCourses', 'title', 'activePage'));
    }

    public function addNews() {
        // à supprimer et remplacer par un bouton pour indiquer son absense.
        if ( \Auth::check() && \Auth::user()->status==1 ) {
            $title = 'Ajouter une notification • ISEP ';
            return view('courses/addNews', compact('title'));
        } 
        return back();
    }

    public function removeCourse( $id_course, $ajax = null ) {    // Quand un élève quite le cours
        $course = \DB::table('course_user')
            ->where('user_id', \Auth::user()->id)
            ->where('course_id', $id_course);

        if( $course->first()->access == 2 ) {
            Notification::create([
                'title' => 'à quiter le cours de',
                'course_id' => $id_course,
                'user_id' => \Auth::user()->id,
                'context' => 4,
                'seen' => 0,
                'for' => Course::where('id', $id_course)->get()->first()->teacher_id
            ]);
        }

        $course->delete();

        \DB::table('notifications')
            ->where('user_id', \Auth::user()->id)
            ->where('course_id', $id_course)
            ->where('context', 1)
            ->update(array('seen' => 3));

        if( $ajax == null ) {
            return redirect()->route('home');
        }

    }

    public function acceptStudent( $id_course, $id_user ) {
        \DB::table('course_user')
        ->where('user_id', $id_user)
        ->where('course_id', $id_course)
        ->update(array('access' => 2));

        Notification::create([
            'title' => 'Vous avez à présent accès au cours de',
            'course_id' => $id_course,
            'user_id' => \Auth::user()->id,
            'context' => 2,
            'seen' => 0,
            'for' => $id_user
        ]);

        \DB::table('notifications')
        ->where('user_id', $id_user)
        ->where('course_id', $id_course)
        ->where('context', 1)
        ->update(array('seen' => 3));

        return redirect()->back();
    }

    public function removeStudent( $id, $ajax = null ) {
        $user = User::findOrFail( $id );
        $courses_user = \DB::table('course_user')->where('user_id', $user->id)->get();
        $courses = [];

        foreach( $courses_user as $course ) {
            $courses[] = Course::findOrFail( $course->course_id );
        }

        foreach( $courses as $course ) {
            if( $course->teacher_id == \Auth::user()->id ) {

                Notification::create([
                    'title' => 'Vous n’avez plus accès au cours',
                    'course_id' => $course->id,
                    'user_id' => \Auth::user()->id,
                    'context' => 5,
                    'seen' => 0,
                    'for' => $user->id
                ]);

                \DB::table('course_user')->where('user_id', $user->id)->where('course_id', $course->id)->delete();
            }
        }
        if( $ajax == null ) {
            return redirect()->back();
        }

    }

    public function removeStudentFromCourse( $id_course, $id_user, $ajax = null ) {
        $course = \DB::table('course_user')
        ->where('user_id', $id_user)->where('course_id', $id_course)->first();

        \DB::table('course_user')
            ->where('user_id', $id_user)->where('course_id', $id_course)->delete();

        \DB::table('notifications')
            ->where('user_id', $id_user)
            ->where('course_id', $id_course)
            ->where('context', 1)
            ->update(array('seen' => 3));

        if( $course->access == 1 ) {
            Notification::create([
                'title' => 'Votre demande d’accès à été refusée',
                'course_id' => $id_course,
                'user_id' => \Auth::user()->id,
                'context' => 3,
                'seen' => 0,
                'for' => $id_user
            ]);
        } else {
            Notification::create([
                'title' => 'Vous n’avez plus accès au cours',
                'course_id' => $id_course,
                'user_id' => \Auth::user()->id,
                'context' => 5,
                'seen' => 0,
                'for' => $id_user
            ]);
        }

        if( $ajax == null ) {
            return redirect()->back();
        }
    }

    public function edit( $id ) {
        $course = Course::findOrFail($id);
        $pageTitle = 'Modifier le cours • ISEP';
        $activePage = "course";
        $id = $course->id;
        $title = $course->title;
        $group = $course->group;
        $school = $course->school;
        $place = $course->place;
        return view('courses/updateCourse', compact('pageTitle', 'id', 'title', 'group', 'school', 'place', 'activePage'));
    }

    public function update( $id ) {
        $errors = Validator::make(Input::all(), $this->rules);
        if ($errors->fails()) {
            return Redirect()->back()->withErrors($errors);
        }
        $course = Course::findOrFail($id);
        $course->title = Input::get('title');
        $course->group = Input::get('group');
        $course->school = Input::get('school');
        $course->place = Input::get('place');
        $course->updated_at = Carbon::now();
        $course->save();
        return redirect()->route('viewCourse', [ 'id' => $id ]);
    }

    public function delete( $id ) {
        $course = Course::findOrFail($id);

        $students = \DB::table('course_user')
            ->where('course_id', $course->id)->get();

        if( !empty($students) ) {
            foreach( $students as $student ) {
                Notification::create([
                    'title' => $course->title,
                    'course_id' => $course->id,
                    'user_id' => \Auth::user()->id,
                    'context' => 17, // Cours supprimé
                    'seen' => 0,
                    'for' => $student->user_id
                ]);
            }
        }

        $seances = Seance::where( 'course_id', '=', $course->id )->get();;
        foreach ($seances as $seance) {

            $works = Work::where( 'seance_id', '=', $seance->id )->get();
            foreach ($works as $work) {
                $work->delete();   
            }

            $tests = Test::where( 'seance_id', '=', $seance->id )->get();
            foreach ($tests as $test) {
                $test->delete();   
            }

            $comments = Comment::where( 'for', '=', $seance->id )->get();
            foreach ($comments as $comment) {
                $comment->delete();
            }

            $seance->delete();   
        }
        $course->delete();
        return redirect()->route('home');
    }

    public function indexUserUsers() 
    {
        $title = "Liste de mes élèves • ISEP";
        $activePage = 'course';
        $studentsID = [];
        $students = [];
        $courses = Course::where( 'teacher_id', \Auth::user()->id )->get();
        foreach ($courses as $course) {
            foreach ($course->users as $user) 
            {
                if ( $user->pivot->access == 2 ) {
                    if ( !in_array($user->id, $studentsID) )
                    {
                        $students[][] = $user;
                        $studentsID[] = $user->id;
                    }
                }
            }
        }

        return view('pages/allMyStudents', compact('students', 'studentsID', 'title', 'activePage'));
    }

    public function indexCourseUsers( $id ) 
    {
        $course = Course::findOrFail($id);
        $title = "Les élèves du cours de ".$course->title.' • ISEP';
        $activePage = 'course';
        $students = Course::findOrFail($id)->users;
        $inCourseStudents = [];
        $inCourseStudentsId = [];
        foreach ($students as $student) 
        {
            if( $student->pivot->access == 2 )
            {
                $inCourseStudents[] = $student;
                $inCourseStudentsId[] = $student->id;
            }
        }

        return view('courses/indexUsers', compact('inCourseStudents', 'inCourseStudentsId', 'title', 'course', 'activePage'));
    }

    public function indexWaitingUsers( $id )
    {
        $course = Course::findOrFail($id);
        $title = "Les demande d'accès au cours de ".$course->title.' • ISEP';
        $activePage = 'course';
        $students = Course::find($id)->users;

        $demandedStudents = [];
        $demandedStudentsId = [];
        foreach ($students as $student) {
            if( $student->pivot->access == 1 ){
                $demandedStudents[] = $student;
                $demandedStudentsId[] = $student->id;
            }
        }

        return view('courses/indexWaitingUsers', compact('demandedStudents', 'demandedStudentsId', 'title', 'course', 'activePage'));
    }
}
