<!DOCTYPE html>
<html lang="fr-BE">
<head>
    <meta charset="UTF-8">
    <title>@yield('title')</title>

    <!-- Favicon -->
    <link rel="apple-touch-icon" sizes="57x57" href="{{ url() }}/img/favicons/apple-touch-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="{{ url() }}/img/favicons/apple-touch-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="{{ url() }}/img/favicons/apple-touch-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="{{ url() }}/img/favicons/apple-touch-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="{{ url() }}/img/favicons/apple-touch-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="{{ url() }}/img/favicons/apple-touch-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="{{ url() }}/img/favicons/apple-touch-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="{{ url() }}/img/favicons/apple-touch-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ url() }}/img/favicons/apple-touch-icon-180x180.png">
    <link rel="icon" type="image/png" href="{{ url() }}/img/favicons/favicon-32x32.png" sizes="32x32">
    <link rel="icon" type="image/png" href="{{ url() }}/img/favicons/favicon-194x194.png" sizes="194x194">
    <link rel="icon" type="image/png" href="{{ url() }}/img/favicons/favicon-96x96.png" sizes="96x96">
    <link rel="icon" type="image/png" href="{{ url() }}/img/favicons/android-chrome-192x192.png" sizes="192x192">
    <link rel="icon" type="image/png" href="{{ url() }}/img/favicons/favicon-16x16.png" sizes="16x16">
    <link rel="manifest" href="{{ url() }}/img/favicons/manifest.json">
    <link rel="mask-icon" href="{{ url() }}/img/favicons/safari-pinned-tab.svg" color="#ff4732">
    <meta name="apple-mobile-web-app-title" content="Stucher">
    <meta name="application-name" content="Stucher">
    <meta name="msapplication-TileColor" content="#ff4732">
    <meta name="msapplication-TileImage" content="{{ url() }}/img/favicons/mstile-144x144.png">
    <meta name="theme-color" content="#ffffff">


    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
    <meta name="Author" content="Loïc Parent" />
    <meta name="Rev" content="info@loic-parent.be" />
    <meta name="keywords" content="Stucher, stucher, école, journal de classe, élève, eleve, professeur, prof, Loïc Parent, Loic Parent, loic parent, loïc parent" />
    <meta name="Description" content="Stucher est un application avec laquelle vous allez pouvoir gérer vos cours au travers d'un journal de classe commun et partagé" />

    <meta name="msvalidate.01" content="D0E096F381DF9BEAFAF771F29EBA1D79" />

    <link rel="canonical" href="http://www.stucher.be" />

    <!-- OG TYPES -->
    <meta property="og:title" content="Stucher • School share" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="http://stucher.be" />
    <meta property="og:description" content="Stucher est un application avec laquelle vous allez pouvoir gérer vos cours au travers d'un journal de classe commun et partagé" />
    <meta property="og:image" content="http://stucher.be/img/home_classroom.jpg" />

    <!-- My custom css and fonts -->
    <link href='https://fonts.googleapis.com/css?family=Asap:400,400italic,700,700italic' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" type="text/css" media="screen" href="{{ url() }}/css/main.css">
    <link rel="stylesheet" type="text/css" media="print" href="{{ url() }}/css/print.css">

    <!-- Calendar popup -->
    <link rel="stylesheet" type="text/css" media="screen" href="{{ url() }}/css/DateTimePicker.min.css" />
    <!--[if lt IE 9]>
    <link rel="stylesheet" type="text/css" media=screen href="{{ url() }}/css/DateTimePicker-ltie9.min.css" />
    <![endif]-->

    <!-- Sweet Alert -->
    <link rel="stylesheet" type="text/css" media="screen" href="{{ url() }}/css/sweetalert.min.css" />
</head>
