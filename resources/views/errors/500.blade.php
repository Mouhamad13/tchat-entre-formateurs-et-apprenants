@extends('logoutLayout')
@section('title', 'Problème sur le serveur • Stucher')
@section('content')

    <body class="{{ isset(Auth::user()->color) ? Auth::user()->color : '' }}">
    <div class="blockTitle">
        <h1 class="mainTitle">Erreur 500</h1>
        <h1 class="subTitle">Une erreur du serveur est survenue. Veuillez ré-essayer plus tard.</h1>

        <a title="Revenir à la page précédente" class="backButton blockTitle__backButton unlink mainColorfont" href="{{ URL::previous() }}"><span class="hidden">Revenir à la page précédente</span><span class="icon-arrow-left"></span></a>
    </div>
@stop