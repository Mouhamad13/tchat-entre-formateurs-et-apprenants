<?php

namespace App\Http\Middleware;

use Closure;
use App\Course;
use App\Seance;
use App\Work;
use App\Test;
use App\Comment;

class IsTheTeacher
{
    public function handle($request, Closure $next)
    {
        if ( in_array('course', $request->segments()) )
        {
            $the_course = Course::where('id', $request->route()->parameter('id'))->first();

            if( $the_course == null )
            {
                return redirect()->route('home', ['popupError' => "notCourse"]);
            } else {
                $the_teacher = $the_course->teacher_id;

                if ($the_teacher != \Auth::user()->id)
                {
                    return redirect()->route('home', ['popupError' => "userAccess"]);
                }
            }

        } else if ( in_array('seance', $request->segments()) )
            {
                $the_seance = Seance::where('id', $request->route()->parameter('id'))->first();

                if( $the_seance == null )
                {
                    return redirect()->route('home', ['popupError' => "notSeance"]);
                } else {
                    $the_course = Course::findOrFail($the_seance->course_id);
                    $the_teacher = $the_course->teacher_id;

                    if ($the_teacher != \Auth::user()->id)
                    {
                        return redirect()->route('home', ['popupError' => "userAccess"]);
                    }
                }
            } else if ( in_array('work', $request->segments()) )
                {
                    $the_work = Work::where('id', $request->route()->parameter('id'))->first();

                    if( $the_work == null )
                    {
                        return redirect()->route('home', ['popupError' => "notWork"]);
                    } else {
                        $the_seance = Seance::findOrFail($the_work->seance_id);
                        $the_course = Course::findOrFail($the_seance->course_id);
                        $the_teacher = $the_course->teacher_id;

                        if ($the_teacher != \Auth::user()->id)
                        {
                            return redirect()->route('home', ['popupError' => "userAccess"]);
                        }
                    }
                } else if ( in_array('test', $request->segments()) )
                    {
                        $the_test = Test::where('id', $request->route()->parameter('id'))->first();

                        if( $the_test == null )
                        {
                            return redirect()->route('home', ['popupError' => "notTest"]);
                        } else {
                            $the_seance = Seance::findOrFail($the_test->seance_id);
                            $the_course = Course::findOrFail($the_seance->course_id);
                            $the_teacher = $the_course->teacher_id;

                            if ($the_teacher != \Auth::user()->id)
                            {
                                return redirect()->route('home', ['popupError' => "userAccess"]);
                            }
                        }
                    }
        return $next($request);
    }
}
