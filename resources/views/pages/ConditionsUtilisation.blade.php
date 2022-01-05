@section('title', $title)
@include( 'header' )
<body class="default logOutPages">

<header class="simpleHeader">

    <a class="simpleHeader__logo noprint" href="{!! action( 'CourseController@index' ) !!}">
       
    </a>
    <img class="mainLogo--print hidden" src="{{ url() }}/img/logo_print.jpg" alt="logo Stucher" width="270" height="68">

    <a title="Revenir à la page précédente" class="unlink backButton--logout" href="{!! action( 'CourseController@index' ) !!}"><span class="hidden">Revenir à la page précédente</span><span class="icon-arrow-left"></span></a>

</header>

<div class="logoutContent">
    <h2>Conditions d'utilisation</h2>

    <h3>Utilisation des données</h3>
    <p>Stucher n’utilise en aucun cas vos données pour d’autres raisons que celle du site. En outre, vous avez la possibilité de modifier ou supprimer les informations que vous donnez au site et de vous désinscrire à tout moment. Pour plus d’information, veuillez vous adresser à
        <a class="unlink" href="mailto:contact@stucher.be">contact@stucher.be</a>
    </p>

    <h3>Responsabilité</h3>
    <p>L'utilisateur se tient pour seul responsable de l'utilisation qu'il fait de l'application. Stucher ne peut être tenus responsable d'éventuels dégâts occasionnés par l'utilisation de cette application qu'ils soient causés par une forme de hacking ou tout autre dysfonctionnement.</p>

    <h3>Illustrations</h3>
    <p>Le site utilise des images libres de droits obtenues sur Internet ou des images que l'utilisateur décide d'ajouter au site. De ce fait, le site n'est pas responsable des choix opérés par ses utilisateurs concernant le droit d'image.</p>
</div>

<footer class="home_footer">
   

    <div class="home_footer--2 home_footer--content">
        <ul>
            <li><a href="{{ action( 'PageController@planDuSite' ) }}">Plan du site</a></li>
            <li><a href="{{ action( 'PageController@useRights' ) }}">Conditions d'utilisation</a></li>
            
        </ul>
    </div>

    <div class="home_footer--3 home_footer--content">
        
        </a>
    </div>

    <div class="clear"></div>

</footer>

@include( 'footer' )