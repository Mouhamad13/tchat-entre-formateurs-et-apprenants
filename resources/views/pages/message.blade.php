@extends('layout')
@section('title', $title)
@section('content')
	<div class="blockTitle">
		<h2 class="mainTitle">Messages</h2>
	</div>
	<a href="{{ action( 'PageController@newMessage' ) }}" class="btn btn-primary">Nouveau message</a>
	<ul class="list-group">
		<li class="list-group-item list-group-item-success" style="margin-top: 1em;">Message de : Grégory Lemmens</li>
		<li class="list-group-item">
			Bonjour Monsieur,
			suite à mon absence de mardi dernier, je me demandais si je devais repasser l'interrogation de ce cours?
			Bien à vous,
			Denis
			<br><a href="{{ action( 'PageController@repMessage' ) }}" class="btn btn-primary">Répondre</a>
			<a href="" class="btn btn-danger">Supprimer</a>
		</li>

		<li class="list-group-item list-group-item-warning" style="margin-top: 1em;">Message de : Pierre Renard</li>
		<li class="list-group-item">
			Bonjour Monsieur,
			Concernant le devoir pour jeudi, doit-on faire 10 ou 15 pages?
			Bien à vous,
			Pierre
			<ul class="list-group">
				<li class="list-group-item list-group-item-warning" style="margin-top: 1em;">votre réponse</li>
				<li class="list-group-item">
					Bonjour Pierre,
					Il s'agit bien de faire 15 pages et non 10.
					Bien à toi,
					M. Latour
				</li>
			</ul>
			<br><a href="{{ action( 'PageController@repMessage' ) }}" class="btn btn-primary">Répondre</a>
			<a href="" class="btn btn-danger">Supprimer</a>
		</li>
	</ul>
@endsection