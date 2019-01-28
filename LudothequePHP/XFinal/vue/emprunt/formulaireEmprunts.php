<!-- Contenu HTML affichage des formulaires -->
<?php
use DAO\Adherent\AdherentDAO;
use DAO\JeuPhysique\JeuPhysiqueDAO;
use DAO\Alerte\AlerteDAO;

function afficherGestionEmprunt($listeEmprunts)
{
    ?>
<form method="post" action="index.php?page=emprunts">
	<table class="table">
		<thead>
			<tr>
				<td colspan="6"><button type="submit" class="btn btn-success"
						name="nouvelEmprunt">Nouvel Emprunt</button></td>
			</tr>
			<tr>
				<th>Date d'emprunt</th>
				<th>Date de retour</th>
				<th>Adhérent</th>
				<th>Jeu</th>
				<th>Alerte</th>
				<th><button type="submit" class="btn btn-danger"
						name="supprimerEmprunt">Supprimer</button>
					<button type="submit" class="btn btn-primary"
						name="modifierEmprunt">Mettre à Jour</button></th>
			</tr>
		</thead>
		<tbody>

<?php

    if (array_key_exists(0, $listeEmprunts)) {
        foreach ($listeEmprunts as $emprunt) {
            $adherent = $emprunt['adherent'];
            $jeu = $emprunt['jeu'];
            $jeuPhysique = $emprunt['jeuPhysique'];
            $alerte = $emprunt['alerte'];
            $alerte = ($alerte != "Aucune") ? $alerte->getNom() : "Aucune";

            ?>
			<tr>
				<td><?php echo $emprunt['dateEmprunt']; ?></td>
				<td><?php echo $emprunt['dateRetourEffectif']; ?></td>
				<td><?php echo strtoupper($adherent->getPrenom()) . " " . $adherent->getNom(); ?></td>
				<td><?php echo $jeu->getTitre(); ?></td>
				<td><?php echo $alerte; ?></td>
				<td><input type="radio" name="idEmprunt"
					value="<?php echo $jeuPhysique->getIdAlerte()."/".$adherent->getIdPersonne()."/".$emprunt['dateEmprunt']; ?>"></td>
			</tr>
<?php
        }
    } else {
        ?>
			<tr>
				<td colspan="6">Aucun emprunt dans la base de donnée</td>
			</tr>
<?php
    }
    ?>
		</tbody>
	</table>
</form>
<?php
}

function afficherFormulaireEmprunt($emprunt)
{
    $isNouvelEmprunt = ($emprunt->getIdAlerte() == "" && $emprunt->getIdAdherent() == "");
    $intituleFormulaire = $isNouvelEmprunt ? "Ajout d'un nouvel emprunt" : "Modification d'un emprunt";
    $idEmprunt = $isNouvelEmprunt ? "" : $emprunt->getIdAlerte() . "/" . $emprunt->getIdAdherent() . "/" . $emprunt->getDateEmprunt();
    // $daoAdherent = new AdherentDAO();
    // $daoEmprunt = new EmpruntDAO();
    // $daoAlerte = new AlerteDAO();
    // $daoJeu = new JeuDAO();
    // $daoJeuPhysique = new JeuPhysiqueDAO();

    ?>
<h3><?php echo $intituleFormulaire; ?></h3>
<div class="col-lg-offset-4 col-lg-4">
	<form method="post" action="index.php?page=emprunts">
		<fieldset>
			<legend>Détails de l'emprunt</legend>
			<div class="form-group">
				<label for="dateEmprunt">Date d'emprunt :</label> <input type="date"
					class="form-control" name="dateEmprunt" id="dateEmprunt"
					value="<?php echo $emprunt->getDateEmprunt(); ?>">
			</div>
			<div class="form-group">
				<label for="dateRetourEffectif">Date de Retour :</label> <input
					type="date" class="form-control" name="dateRetourEffectif"
					id="dateRetourEffectif"
					value="<?php echo $emprunt->getDateRetourEffectif(); ?>">
			</div>
			<div class="form-group">
				<label for="adherent">Adhérent :</label> <select
					class="form-control" name="adherent" id="adherent">
					<option value="" selected>Aucun</option>				
<?php
    $listeAdherents = AdherentDAO::getAdherents();
    if (array_key_exists(0, $listeAdherents)) {
        foreach ($listeAdherents as $adherent) {
            $selected = ($adherent->getIdPersonne() == $emprunt->getIdAdherent()) ? "selected" : "";
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
            $selected = ($jeuxPhysique['idJeuPhysique'] == $emprunt->getIdAlerte()) ? "selected" : "";
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
<?php if ($isNouvelEmprunt) {?>
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
                $selected = ($alerte->getIdAlerte() == $emprunt->getIdAlerte()) ? "selected" : "";
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
				value="<?php echo $idEmprunt; ?>"> <input type="submit"
				class="form-control" name="formulaireMaj" value="Mettre à Jour">
		</div>
<?php
    }
    ?>
</form>
</div>
<?php
}