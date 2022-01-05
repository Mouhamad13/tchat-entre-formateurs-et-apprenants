<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\User;
use App\Course;
use App\Notification;
use App\Seance;
use App\Comment;
use \Input;
use Validator;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $createRules = [
        'comment' => 'required',
    ];
    public function create()
    {
        setlocale( LC_ALL, 'fr_FR.UTF-8');
        $error = Validator::make(Input::all(), $this->createRules);
        if ($error->fails()) {
            return redirect()->back()->withErrors($error);
        }

        $body = Input::get('comment');
        $from = \Auth::user()->id; // the actif user
        $for = Input::get('for'); // ID SEANCE car seance = seul context actuel.
        $context = Input::get('context');   // 1 = seance // 2 = test // 3 = work

        $comment = Comment::create([
            'body' => $body,
            'from' => $from,
            'for' => $for,
            'context' => $context
        ]);


        $seance = Seance::findOrFail( $for );
        $course = $seance->course;

        $teacher = User::findOrFail( $course->teacher_id );

        $students = \DB::table('course_user')
            ->where('course_id', $course->id)->get();

        if( \Auth::user()->status == 2 ) {
            Notification::create([
                // Nouveau commentaire
                'title' => $seance->start_hours->formatLocalized('%d %B %Y'),
                'course_id' => $course->id,
                'seance_id' => $seance->id,
                'user_id' => \Auth::user()->id,
                'context' => 18,
                'seen' => 0,
                'for' => $teacher->id
            ]);
        }

        if( !empty($students) ) {
            foreach( $students as $student ) {
                if( $student->user_id != \Auth::user()->id ){
                    Notification::create([
                        // Nouveau commentaire
                        'title' => $seance->start_hours->formatLocalized('%d %B %Y'),
                        'course_id' => $course->id,
                        'seance_id' => $seance->id,
                        'user_id' => \Auth::user()->id,
                        'context' => 18,
                        'seen' => 0,
                        'for' => $student->user_id
                    ]);
                }
            }
        }


        return back();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id, $ajax = null)
    {
        $comment = Comment::find($id);
        // WARNING Change if multiple context
        $teacherID = Seance::findOrFail($comment->for)->course->teacher_id;
        if( $comment == null ) {
            return redirect()->route('home', ['popupError' => "notComment"]);
        } else {
            // Verify if it's my comment => middleware
            if( $comment->from != \Auth::user()->id ) {
                if( \Auth::user()->id == $teacherID ) {
                    $comment->delete();
                    if( $ajax == null ){
                        return back();
                    }
                }
                return redirect()->route('home', ['popupError' => "commentAccess"]);
            } else {
                $comment->delete();
                if( $ajax == null ){
                    return back();
                }
            }
        }
    }
}
