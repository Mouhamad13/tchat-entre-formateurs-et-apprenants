@section('title', $title)
@include( 'header' )
<body class="default logOutPages">

<header class="simpleHeader">

    <a class="simpleHeader__logo noprint" href="{!! action( 'CourseController@index' ) !!}">
        
    </a>
    
    <a title="Revenir à la page précédente" class="unlink backButton--logout" href="{!! action( 'CourseController@index' ) !!}"><span class="hidden">Revenir à la page précédente</span><span class="icon-arrow-left"></span></a>

</header>

<ul class="logoutContent">
    <h2>Plan du site</h2>
    <li><a href="{{ action( 'CourseController@index' ) }}">Accueil</a></li>
    <li><a href="{{ action( 'Auth\AuthController@getLogin' ) }}">Page de connexion</a></li>
    <li><a href="{{ action( 'Auth\AuthController@getRegister' ) }}">Page d'inscription</a></li>
    <li><a href="{{ action( 'PageController@useRights' ) }}">Condition d'utilisation</a></li>
    <li><a href="{{ action( 'PageController@planDuSite' ) }}">Plan du site</a></li>
</ul>

<footer class="home_footer">
   

    <div class="home_footer--2 home_footer--content">
        <ul>
            <li><a href="{{ action( 'PageController@planDuSite' ) }}">Plan du site</a></li>
            <li><a href="{{ action( 'PageController@useRights' ) }}">Conditions d'utilisation</a></li>
            
        </ul>
    </div>

    

    <div class="clear"></div>

</footer>


@include( 'footer' )