@extends('layout')
@section('title', 'Nouveau message')
@section('content')

    <div class="blockTitle">
        <h2 class="mainTitle">Nouveau message</h2>
    </div>
	<form method="POST" action="">
        {!! csrf_field() !!}

        <div class="form-group">
            <label for="sendto">À</label>
            <select class="form-control" multiple="multiple" name="sendto" id="sendto" size="10">
            	<optgroup label="3TQ">
            		<option value="">Tous le groupe</option>
            		<option value="">David Lapin</option>
            		<option value="">Thomas Latour</option>
            		<option value="">Grégory Devis</option>
            	</optgroup>
            	<optgroup label="4TQ">
            		<option value="">Tous le groupe</option>
            		<option value="">Mélissa Neudo</option>
            		<option value="">Fanny Granjean</option>
            		<option value="">Kévin Delforge</option>
            	</optgroup>
            	<optgroup label="Par groupe">
            		<option value="">Tous mes groupes</option>
					<option value="">3TQ</option>
					<option value="">4TQ</option>
            	</optgroup>
            </select>
        </div>

        <div class="form-group">
            <label for="objet">Objet du message</label>
            <input class="form-control" placeholder="Entrez l'objet du message ici" type="text" name="objet" id="objet">
        </div>

        <div class="form-group">
            <label for="message">message</label>
            <textarea class="form-control" placeholder="Entrez le contenu du message ici" name="message" id="message" cols="30" rows="10"></textarea>
        </div>

        <div class="form-group">
            <button class="btn btn-default" type="submit">Envoyer le message</button>
        </div>
        
    </form>

@endsection
