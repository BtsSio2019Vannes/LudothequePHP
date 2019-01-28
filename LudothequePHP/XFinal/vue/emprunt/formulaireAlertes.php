<!-- Contenu HTML affichage des formulaires -->
<?php
use DAO\Adherent\AdherentDAO;
use DAO\JeuPhysique\JeuPhysiqueDAO;
use DAO\Alerte\AlerteDAO;

function afficherGestionAlerte($listeAlertes)
{
    ?>
<form method="post" action="index.php?page=emprunts&action=gererAlerte">
	<table class="table">
		<thead>
			<tr>
				<td colspan="5"><button type="submit" class="btn btn-success"
						name="nouvelleAlerte">Nouvelle Alerte</button></td>
			</tr>
			<tr>
				<th>Nom de l'alerte</th>
				<th>Date de retour</th>
				<th>Type d'alerte</th>
				<th>Commentaire</th>
				<th><button type="submit" class="btn btn-danger"
						name="supprimerAlerte">Supprimer</button>
					<button type="submit" class="btn btn-primary"
						name="modifierAlerte">Mettre à Jour</button></th>
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
	<form method="post" action="index.php?page=emprunts&action=gererAlerte">
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
					<option value="" selected>Aucun</option>				
<?php
    $listeAdherents = AdherentDAO::getAdherents();
    if (array_key_exists(0, $listeAdherents)) {
        foreach ($listeAdherents as $adherent) {
            $selected = ($adherent->getIdPersonne() == $alerte->getIdAdherent()) ? "selected" : "";
            ?>
                <option
						value="<?php echo $adherent->getIdPersonne(); ?>"
						<?php echo $selected; ?>><?php echo $adherent->getNom() . " " . $adherent->getPrenom() . " ne(e) le " . $adherent->getDateNaissance(); ?></option>
<?php
        }
    }
    ?>

				</select>
			</div>
			<div class="form-group">
				<label for="jeuPhysique">Jeu à Emprunter :</label> <select
					class="form-control" name="jeuPhysique" id="jeuPhysique">
					<option value="" selected>Aucun</option>	
<?php
    $listeJeuxPhysiques = JeuPhysiqueDAO::getJeuxPhysiquesTries();
    if (array_key_exists(0, $listeJeuxPhysiques)) {
        foreach ($listeJeuxPhysiques as $jeuxPhysique) {
            $selected = ($jeuxPhysique['idJeuPhysique'] == $alerte->getIdAlerte()) ? "selected" : "";
            ?>
                <option
						value="<?php echo $jeuxPhysique['idJeuPhysique']; ?>"
						<?php echo $selected; ?>><?php echo $jeuxPhysique['titre'] . " n°" . $jeuxPhysique['idJeuPhysique']; ?></option>
<?php
        }
    }
    ?>
				</select>
			</div>
		</fieldset>
<?php if ($isNouvelleAlerte) {?>
	<div class="form-group">
			<input type="submit" class="form-control" name="formulaireAjout"
				value="Créer Nouvel Emprunt">
		</div>
<?php
    } else {
        ?>
        <fieldset>
			<legend>Alerte</legend>
			<div class="form-group">
				<label for="alerte">Alerte :</label> <select class="form-control"
					name="alerte" id="alerte">
					<option value="" selected>Aucun</option>				
<?php
        $listeAlertes = AlerteDAO::getAlertes();
        if (array_key_exists(0, $listeAlertes)) {
            foreach ($listeAlertes as $alerte) {
                $selected = ($alerte->getIdAlerte() == $alerte->getIdAlerte()) ? "selected" : "";
                ?>
                <option value="<?php echo $alerte->getIdAlerte(); ?>"
						<?php echo $selected; ?>><?php echo $alerte->getNom(); ?></option>
<?php
            }
        }
        ?>
				</select>
				<a href="index.php?page=emprunts&action=ajouterAlerte">Créer une nouvelle alerte</a>
			</div>
		</fieldset>
		<div class="form-group">
			<input type="hidden" name="idEmprunt"
				value="<?php echo $idAlerte; ?>"> <input type="submit"
				class="form-control" name="formulaireMaj" value="Mettre à Jour">
		</div>
<?php
    }
    ?>
</form>
</div>
<?php
}