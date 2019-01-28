<!-- Contenu HTML affichage des formulaires -->
<?php
use DAO\Alerte\AlerteDAO;

function afficherGestionAlerte($listeAlertes) 
{
    ?>
<form method="post" action="index.php?page=emprunts">
	<table class="table">
		<thead>
			<tr>
				<td colspan="5"><button type="submit" class="btn btn-success"
						name="nouvelleAlerte"><span class="glyphicon glyphicon-plus"></span> Nouvelle Alerte</button></td>
			</tr>
			<tr>
				<th>Nom de l'alerte</th>
				<th>Date de retour</th>
				<th>Type d'alerte</th>
				<th>Commentaire</th>
				<th><button type="submit" class="btn btn-danger"
						name="supprimerAlerte"><span class="glyphicon glyphicon-remove"></span> Supprimer</button>
					<button type="submit" class="btn btn-primary"
						name="modifierAlerte"><span class="glyphicon glyphicon-edit"></span> Mettre à Jour</button></th>
			</tr>
		</thead>
		<tbody>

<?php

    if (array_key_exists(0, $listeAlertes)) {
        foreach ($listeAlertes as $alerte) {
            $commentaire = $alerte->getCommentaire();
            $commentaire = ($commentaire != "") ? substr($commentaire, 0, 20) . "..." : "";
            ?>
			<tr>
				<td><?php echo $alerte->getNom(); ?></td>
				<td><?php echo $alerte->getDateRetour(); ?></td>
				<td><?php echo $alerte->getTypeAlerte(); ?></td>
				<td><?php echo $commentaire; ?></td>
				<td><input type="radio" name="idAlerte"
					value="<?php echo $alerte->getIdAlerte(); ?>"></td>
			</tr>
<?php
        }
    } else {
        ?>
			<tr>
				<td colspan="6">Aucune Alerte dans la base de donnée</td>
			</tr>
<?php
    }
    ?>
		</tbody>
	</table>
</form>
<?php
}

function afficherFormulaireAlerte($alerte)
{
    $isNouvelleAlerte = ($alerte->getIdAlerte() == "");
    $intituleFormulaire = $isNouvelleAlerte ? "Ajout d'une nouvelle alerte" : "Modification d'une alerte";
    $idAlerte = $isNouvelleAlerte ? "" : $alerte->getIdAlerte();

    ?>
<h3><?php echo $intituleFormulaire; ?></h3>
<div class="col-lg-offset-4 col-lg-4">
	<form method="post" action="index.php?page=emprunts">
			<div class="form-group">
				<label for="nom">Nom :</label> <input type="text"
					class="form-control" name="nom" id="nom"
					value="<?php echo $alerte->getNom(); ?>">
			</div>
			<div class="form-group">
				<label for="dateRetour">Date de Retour :</label> <input
					type="date" class="form-control" name="dateRetour"
					id="dateRetour"
					value="<?php echo $alerte->getDateRetour(); ?>">
			</div>
			<div class="form-group">
				<label for="typeAlerte">Type d'Alerte :</label> <select
					class="form-control" name="typeAlerte" id="typeAlerte">
					<option value="" selected>Aucune</option>				
<?php
    $listeTypesAlerte = AlerteDAO::getTypesAlerte();
    if (array_key_exists(0, $listeTypesAlerte)) {
        foreach ($listeTypesAlerte as $typeAlerte) {
            $selected = ($alerte->getTypeAlerte() == $typeAlerte) ? "selected" : "";
            ?>
                <option
						value="<?php echo $typeAlerte; ?>"
						<?php echo $selected; ?>><?php echo $typeAlerte; ?></option>
<?php
        }
    }
    ?>

				</select>
			</div>
			<div class="form-group">
				<label for="commentaire">Commentaire :</label> <textarea class="form-control" name="commentaire" id="commentaire"><?php echo $alerte->getCommentaire(); ?></textarea>
			</div>
<?php if ($isNouvelleAlerte) {?>
	<div class="form-group">
			<input type="submit" class="form-control" name="formulaireAjoutAlerte"
				value="Créer Nouvelle Alerte">
		</div>
<?php
    } else {
        ?>
		<div class="form-group">
			<input type="hidden" name="idAlerte"
				value="<?php echo $idAlerte; ?>"> <input type="submit"
				class="form-control" name="formulaireMajAlerte" value="Mettre à Jour">
		</div>
<?php
    }
    ?>
</form>
</div>
<?php
}