@extends( 'layout' )
@section( 'content' )
@section( 'title', $title )
<div class="blockTitle">
    <h2 class="mainTitle">Cours de {{ $course->title }}</h2>
    <h3 class="subTitle">Groupe&nbsp;: {{ $course->group }}</h3>

    <a title="Revenir à la page précédente" class="backButton blockTitle__backButton unlink mainColorfont" href="{!! action( 'CourseController@searchCourse' ) !!}"><span class="hidden">Revenir à la page précédente</span><span class="icon-arrow-left"></span></a>
</div>
    <h3 class="item--null" >Cours en attente de validation</h3>
@stop