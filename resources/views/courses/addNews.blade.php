@extends( 'layout' )
	@section('title', $title)
    @section( 'content' )
    <h2><?php echo $title; ?></h2>
	<form action="" method="post">
		<div class="form-group">
			<input type="hidden" name="_token" value="{{ csrf_token() }}">
			<label for="title">Quel est l'objet de la notification</label>
			<select class="form-control" name="title" id="title">
            		<option value="">Absence</option>
            		<option value="">Sortie scolaire</option>
            		<option value="">Retard</option>
            		<option value="">Changement de local</option>
            		<option value="">Notes</option>
            		<option value="">Journée pédagogique</option>
            		<option selected="selected" value="">Autre</option>
            </select>
            <input class="form-control" type="text" id="addTitle" name="addTitle" placeholder="Nouvel objet de notification">
		</div>
		<div class="form-group">
            <label for="sendto">Pour quoi?</label>
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
			<label for="descr">Description de la notification</label>
			<textarea class="form-control" name="descr" id="descr" cols="30" rows="10" placeholder="ex: La matière de cette interrogation portera sur…"></textarea>
		</div>
		<div class="form-group">
			<label for="file">Fichier joins (facultatif - PDF, image ou Word)</label>
			<input type="file" id="file" name="file">
		</div>
		<div class="form-group">
			<label for="date">Quand (date)</label>
			<select class="form-control" name="date" id="date">
                        <option value="">Le prochain cours</option>
            		<option value="">La semaine prochaine</option>
            		<option value="">Le cours du 20 novembre</option>
            		<option value="">Le cours du 27 novembre</option>
            		<option value="">Le cours du 4 décembre</option>
            </select>
		</div>
		<div class="form-group text-center">
			<input type="submit" class="btn btn-primary" value="Valider la notification">
		</div>
	</form>
@stop