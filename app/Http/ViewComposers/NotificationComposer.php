<?php

namespace App\Http\ViewComposers;

use Illuminate\Contracts\View\View;
use \App\Notification;
use \App\Course;
use \App\Seance;
use \App\Work;
use \App\Test;
use \App\User;
use DB;


class NotificationComposer
{
    public function compose(View $view)
    {	
    	
    	if( \Auth::check() ){
 	    	$view->with( 'notifications', DB::table('notifications as not')
 	    	->select('not.id AS not_id', 'not.title AS not_title', 'not.for AS not_for', 'not.course_id AS not_course_id', 'not.seance_id AS not_seance_id', 'not.work_id AS not_work_id', 'not.test_id AS not_test_id', 'not.message_id AS not_message_id', 'not.user_id AS not_user_id', 'not.context AS not_context', 'not.seen AS not_seen', 'not.created_at AS not_created_at', 'not.updated_at AS not_updated_at', 'users.id AS user_id', 'users.firstname AS user_firstname', 'users.name AS user_name', 'users.email AS user_email', 'users.status AS user_status', 'works.id AS work_id', 'works.seance_id AS work_seance_id', 'works.title AS work_title', 'works.file AS work_file', 'works.description AS work_description', 'works.created_at AS work_created_at', 'works.updated_at AS work_updated_at', 'tests.id AS test_id', 'tests.seance_id AS test_seance_id', 'tests.title AS test_title', 'tests.file AS test_file', 'tests.description AS test_description', 'tests.created_at AS test_created_at', 'tests.updated_at AS test_updated_at', 'courses.id AS course_id', 'courses.teacher_id AS course_teacher_id', 'courses.title AS course_title', 'courses.group AS course_group', 'courses.school AS course_school', 'courses.place AS course_place', 'courses.created_at AS course_created_at', 'courses.updated_at AS course_updated_at', 'seances.id AS seance_id', 'seances.course_id AS seance_course_id', 'seances.classroom_id AS seance_classroom_id', 'seances.start_hours AS seance_start_hours', 'seances.end_hours AS seance_end_hours', 'seances.created_at AS seance_created_at', 'seances.updated_at AS seance_updated_at')
            ->leftJoin('users', 'not.user_id', '=', 'users.id')
            ->leftJoin('works', 'not.work_id', '=', 'works.id')
            ->leftJoin('tests', 'not.test_id', '=', 'tests.id')
            ->leftJoin('courses', 'not.course_id', '=', 'courses.id')
            ->leftJoin('seances', 'not.seance_id', '=', 'seances.id')
            ->where('not.for', '=', \Auth::user()->id)
            ->where('not.seen', '=', 0)	// Si la notification n'a pas élé vue (clic sur la page notification)
            ->orderBy('not_id', 'desc')
            ->get() );
 	    }

    }
}