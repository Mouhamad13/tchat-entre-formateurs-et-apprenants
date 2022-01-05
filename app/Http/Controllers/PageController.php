<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Validator;
use \Input;

use App\Course;
use App\Seance;
use App\Work;
use App\Test;
use App\Comment;
use App\User;
use DB;
use \Image;
use \File;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class PageController extends Controller
{

    protected $rulesProfil = [
        'firstname' => 'required|max:255',
        'name' => 'required|max:255',
        'email' => 'required|email|max:255'
        ];
    protected $rulesPassword = [
        'password' => 'required|min:6',
        'password_confirmation' => 'required|same:password'
    ];

    public function about(){
		$title = "Mon profil • ISEP";
        $activePage = 'profil';
        $nbCourses = Course::where('teacher_id', '=', \Auth::user()->id)->count();
        $coursesStudent = DB::select('select * from stucher_course_user where user_id = '.\Auth::user()->id);
        $nbCoursesStudent = count($coursesStudent);
        $courses = Course::where('teacher_id', '=', \Auth::user()->id)->get();
        $myUsers = [];
        foreach ($courses as $course) {
        
         $users =  $course->users;
         foreach ($users as $user) {
             if( $user->pivot->access != 1 ) {
                 if (!in_array($user->id, $myUsers)) {
                     array_push($myUsers, $user->id);
                 }
             }
         }
        }
        $nbUsers = count($myUsers);
		return view('pages/about', compact('title', 'nbCourses', 'nbUsers', 'nbCoursesStudent', 'activePage'));
    }

    public function viewUser( $id )
    {
        $user = User::findOrFail( $id );
        $title = "Le profil de ".$user->firstname.' '.$user->name.' • ISEP';
        $courses = Course::where( 'teacher_id', $id )->get();
        return view('pages/viewUser', compact('title', 'user', 'courses'));
    }

    public function editProfil() {
        $title = 'Modifier mon profil • ISEP';
        $activePage = 'profil';
        $id = \Auth::user()->id;
        $user = User::findOrFail($id);
        $name = $user->name;
        $firstname = $user->firstname;
        $email = $user->email;
        return view('pages/updateProfil', compact('id', 'firstname', 'name', 'email', 'title', 'activePage'));
    }

    public function updateProfil() {
        $errors = Validator::make(Input::all(), $this->rulesProfil);
        if ($errors->fails()) {
            return redirect()->back()->withErrors($errors);
        }
        $user = User::findOrFail( \Auth::user()->id );
        $user->firstname = Input::get('firstname');
        $user->name = Input::get('name');
        $user->email = Input::get('email');
        $user->save();
        return redirect()->route('about');
    }

    public function editPassword() {
        $title = 'Changer mon mot de passe • ISEP';
        $activePage = 'profil';
        $id = \Auth::user()->id;
        return view('pages/updatePassword', compact('id', 'title', 'activePage'));
    }

    public function updatePassword() {
        $errors = Validator::make(Input::all(), $this->rulesPassword);
        if ($errors->fails()) {
            return redirect()->back()->withErrors($errors);
        }
        $user = User::findOrFail( \Auth::user()->id );
        $user->password = bcrypt(Input::get('password'));
        $user->save();
        return redirect()->route('about');
    }

    public function deleteProfil() {
        $user = User::findOrFail(\Auth::user()->id);
        if ( $user->image != "default.jpg" )
            {
                File::delete( public_path( 'img/profilPicture/' . \Auth::user()->image ) );
            }


        if( \Auth::user()->status == 1 )
        {
            $courses = Course::where( 'teacher_id', \Auth::user()->id )->get();
            foreach( $courses as $course )
            {
                $seances = Seance::where( 'course_id', '=', $course->id )->get();;
                foreach ($seances as $seance)
                {
                    $works = Work::where( 'seance_id', '=', $seance->id )->get();
                    foreach ($works as $work)
                    {
                        $work->delete();
                    }

                    $tests = Test::where( 'seance_id', '=', $seance->id )->get();
                    foreach ($tests as $test)
                    {
                        $test->delete();
                    }

                    $comments = Comment::where( 'from', '=', \Auth::user()->id )->get();
                    foreach ($comments as $comment)
                    {
                        $comment->delete();
                    }

                    $seance->delete();
                }
                $course->delete();
            }
        }

        $user->delete();
        return redirect()->route('home');
    }

    public function changePicture()
    {
        $title = "Changer la photo de profil • ISEP";
        $activePage = 'profil';
        return view( 'pages/changePicture', ['title' => $title, 'activePage' => $activePage] );
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

// TODO Déplacer quand je fais les message
    public function message(){
        if ( \Auth::check() ) {
            $title = "Message • ISEP";
            $activePage = 'message';
            return view('pages/message', ['title' => $title, 'activePage' => $activePage]);
        }
        return view('welcome', ['title' => $title]);
    }

    public function newMessage(){
        if ( \Auth::check() ) {
            return view('pages/newMessage');
        }
        return view('welcome', ['title' => $title]);
    }

    public function repMessage(){
        if ( \Auth::check() ) {
            return view('pages/repMessage');
        }
        return view('welcome', ['title' => $title]);
    }
// Déplacer quand je fais les message >

    public function registerTeacher(){
        $title = "Créer un compte professeur • ISEP";
        return view( 'auth/registerTeacher', ['title' => $title] );
    }

    public function registerStudent(){
        $title = "Créer un compte étudiant • ISEP";
        return view( 'auth/registerStudent', ['title' => $title] );
    }

    public function changeColor(){
        $title = "La couleur du thème • ISEP";
        $activePage = 'profil';
        return view( 'pages/listColor', ['title' => $title, 'activePage' => $activePage] );
    }

    public function updateColor( $number ){
        $user = User::findOrFail( \Auth::user()->id );
        $user->color = 'color_'.$number;
        $user->save();
        return redirect()->back();
    }

    public function planDuSite(){
        $title = "Plan du site • ISEP";
        return view( 'pages/planDuSite', ['title' => $title] );
    }

    public function useRights(){
        $title = "Conditions d’utilisation • ISEP";
        return view( 'pages/ConditionsUtilisation', ['title' => $title] );
    }

}
