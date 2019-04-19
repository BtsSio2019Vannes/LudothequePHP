<!-- Contenu HTML affichage des formulaires -->
<?php

function afficherGestionEditeur($listeEditeurs)
{
    ?>
<form method="post" action="index.php?page=jeux">
	<table class="table">
		<thead>
			<tr>
				<td colspan="3"><button type="submit" class="btn btn-success"
						name="nouvelEditeur">
						<span class="glyphicon glyphicon-plus"></span> Nouvel Editeur
					</button>
					<button type="submit" class="btn btn-danger" name="supprimerEditeur">
						<span class="glyphicon glyphicon-remove"></span> Supprimer
					</button>
					<button type="submit" class="btn btn-primary" name="modifierEditeur">
						<span class="glyphicon glyphicon-edit"></span> Mettre à Jour
					</button> <a href="index.php?page=jeux&action=gererJeux"
					class="btn btn-info"><span
						class="glyphicon glyphicon-exclamation-sign"></span> Gérer les
						catégories de jeu</a></td>
			</tr>
			<tr>
				<th>Nom</th>
				<th>Coordonnées</th>
				<th></th>
			</tr>
		</thead>
		<tbody>

<?php
    if (sizeof($listeEditeurs)) {
        foreach ($listeEditeurs as $editeur) {
            ?>
			<tr>
				<td><?php echo $editeur->getNom(); ?></td>
				<td><?php echo $editeur->getCoordonnees(); ?></td>
				<td><input type="radio" name="idEditeur"
					value="<?php echo $editeur->getIdEditeur(); ?>"></td>
			</tr>
<?php
        }
    } else {
        ?>
			<tr>
				<td colspan="3">Aucun editeur dans la base de données</td>
			</tr>
<?php
    }
    ?>
		
		
		</tbody>
	</table>
</form>
<?php
}

function afficherFormulaireEditeur($editeur)
{
    $isNouvelEditeur = ($editeur->getIdEditeur() == "");
    $intituleFormulaire = $isNouvelEditeur ? "Ajout d'un nouvel editeur" : "Modification d'un editeur";
    $idEditeur = $isNouvelEditeur ? "" : $editeur->getIdEditeur();

    ?>
<h3><?php echo $intituleFormulaire; ?></h3>
    <a href="index.php?page=jeux&action=gererEditeurs"
					class="btn btn-warning"><span
						class="glyphicon glyphicon-backward"></span> Gérer les Editeurs</a>
<div class="col-lg-offset-4 col-lg-4">
	<form method="post" action="index.php?page=editeurs">
		<fieldset>
			<legend>Détails du editeur</legend>
			<div class="form-group">
				<label for="nom">Nom :</label> <input type="text"
					class="form-control" name="nom" id="nom"
					value="<?php echo $editeur->getNom(); ?>">
			</div>
			<div class="form-group">
				<label for="rue">Rue :</label> <input type="text"
					class="form-control" name="rue" id="rue"
					value="<?php echo $editeur->getCoordonnees()->getRue(); ?>">
			</div>
			<div class="form-group">
				<label for="codePostal">Code Postal :</label> <input type="text"
					class="form-control" name="codePostal" id="codePostal"
					value="<?php echo $editeur->getCoordonnees()->getCodePostal(); ?>">
			</div>
			<div class="form-group">
				<label for="ville">Ville :</label> <input type="text"
					class="form-control" name="ville" id="ville"
					value="<?php echo $editeur->getCoordonnees()->getVille(); ?>">
			</div>
		</fieldset>
<?php if ($isNouvelEditeur) {?>
	<div class="form-group">
			<input type="submit" class="form-control" name="formulaireAjoutEditeur"
				value="Créer Nouveau Editeur">
		</div>
<?php
    } else {
        ?>
        <div class="form-group">
			<input type="hidden" name="idEditeur" value="<?php echo $idEditeur; ?>"> <input
				type="submit" class="form-control" name="formulaireMajEditeur"
				value="Mettre à Jour">
		</div>
<?php
    }
    ?>
</form>
</div>
<?php
}