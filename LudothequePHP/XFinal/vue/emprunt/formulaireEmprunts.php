<!-- Contenu HTML affichage des formulaires -->
<?php
use DAO\Adherent\AdherentDAO;
use DAO\JeuPhysique\JeuPhysiqueDAO;
use DAO\Alerte\AlerteDAO;
use DAO\Reglement\ReglementDAO;
use DAO\Emprunt\EmpruntDAO;

function afficherGestionEmprunt($listeEmprunts) 
{
    ?>
<form method="post" action="index.php?page=emprunts">
	<table class="table">
		<thead>
			<tr>
				<td colspan="6"><button type="submit" class="btn btn-success"
						name="nouvelEmprunt">
						<span class="glyphicon glyphicon-plus"></span> Nouvel Emprunt
					</button>
						<button type="submit" class="btn btn-danger"
						name="supprimerEmprunt">
						<span class="glyphicon glyphicon-remove"></span> Supprimer
					</button>
					<button type="submit" class="btn btn-primary"
						name="modifierEmprunt">
						<span class="glyphicon glyphicon-edit"></span> Mettre à Jour
					</button> <a href="index.php?page=emprunts&action=gererAlerte"
					class="btn btn-info"><span
						class="glyphicon glyphicon-exclamation-sign"></span> Gérer les
						Alertes</a>
						</td>
			</tr>
			<tr>
				<th>Date d'emprunt</th>
				<th>Date de retour</th>
				<th>Adhérent</th>
				<th>Jeu</th>
				<th>Alerte</th>
				<th></th>
			</tr>
		</thead>
		<tbody>

<?php

    if (array_key_exists(0, $listeEmprunts)) {
        foreach ($listeEmprunts as $emprunt) {
            $adherent = $emprunt['adherent'];
            $jeuPhysique = $emprunt['jeuPhysique'];
            $alerte = $emprunt['alerte'];
            $alerte = ($alerte != "Aucune") ? $alerte->getNom() : "Aucune";

            ?>
			<tr>
				<td><?php echo $emprunt['dateEmprunt']; ?></td>
				<td><?php echo $emprunt['dateRetourEffectif']; ?></td>
				<td><?php echo strtoupper($adherent->getPrenom()) . " " . $adherent->getNom(); ?></td>
				<td><?php echo $jeuPhysique->getTitre(); ?></td>
				<td><?php echo $alerte; ?></td>
				<td><input type="radio" name="idEmprunt"
					value="<?php echo $jeuPhysique->getIdJeuPhysique()."/".$adherent->getIdPersonne()."/".$emprunt['dateEmprunt']; ?>"></td>
			</tr>
<?php
        }
    } else {
        ?>
			<tr>
				<td colspan="6">Aucun emprunt dans la base de données</td>
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
    $isNouvelEmprunt = ($emprunt->getIdJeuPhysique() == "" && $emprunt->getIdAdherent() == "");
    $intituleFormulaire = $isNouvelEmprunt ? "Ajout d'un nouvel emprunt" : "Modification d'un emprunt";
    $idEmprunt = $isNouvelEmprunt ? "" : $emprunt->getIdAlerte() . "/" . $emprunt->getIdAdherent() . "/" . $emprunt->getDateEmprunt();
    $daoReglement = new ReglementDAO();
    $daoEmprunt = new EmpruntDAO();

    ?>
<h3><?php echo $intituleFormulaire; ?></h3>
    <a href="index.php?page=emprunts"
					class="btn btn-warning"><span
						class="glyphicon glyphicon-backward"></span> Gérer les Emprunts</a>
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
            $nbEmpruntEnCours = $daoEmprunt->retrouverNbEmpruntEnCours($adherent->getIdPersonne());
            $reglement = $daoReglement->read($adherent->getReglement());
            $selected = ($adherent->getIdPersonne() == $emprunt->getIdAdherent()) ? " selected" : "";
            $disabled = ($nbEmpruntEnCours == $reglement->getNbrJeux() && $selected == "") ? " disabled" : "";
            ?>
                <option
						value="<?php echo $adherent->getIdPersonne(); ?>"
						<?php echo $selected . $disabled; ?>><?php echo $adherent->getNom() . " " . $adherent->getPrenom() . " ne(e) le " . $adherent->getDateNaissance() . " " . $nbEmpruntEnCours . "/" . $reglement->getNbrJeux(); ?></option><?php
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
    $titreJeu = "";
    $listeJeuxPhysiquesTries = JeuPhysiqueDAO::getJeuxPhysiquesTries();
    if (sizeof($listeJeuxPhysiquesTries)) {
        foreach ($listeJeuxPhysiquesTries as $cle => $listeJeuxPhysiques) {
            if ($titreJeu != $cle) {
                $titreJeu = $cle;
                ?>
            	<optgroup label="<?php echo $titreJeu; ?>">
            	<?php
            }
            foreach ($listeJeuxPhysiques as $jeuxPhysique) {
                $isEmprunte = $daoEmprunt->isEmprunte($jeuxPhysique['idJeuPhysique']);
                $selected = ($jeuxPhysique['idJeuPhysique'] == $emprunt->getIdJeuPhysique()) ? " selected" : "";
                $disabled = ($isEmprunte == 1 && $selected == "") ? " disabled" : "";
                $estEmprunte = ($isEmprunte == 1 && $selected == "") ? " indisponible" : "";
            ?>
                <option value="<?php echo $jeuxPhysique['idJeuPhysique']; ?>"
                <?php echo $selected . $disabled; ?>>n°<?php echo $jeuxPhysique['idJeuPhysique'] . "" . $estEmprunte; ?></option>
<?php
            }
?>
				</optgroup>
<?php
            }
    }
    ?>
				
				
				</select>
			</div>
		</fieldset>
<?php if ($isNouvelEmprunt) {?>
	<div class="form-group">
			<input type="submit" class="form-control"
				name="formulaireAjoutEmprunt" value="Créer Nouvel Emprunt">
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
			</div>
		</fieldset>
		<div class="form-group">
			<input type="hidden" name="idEmprunt"
				value="<?php echo $idEmprunt; ?>"> <input type="submit"
				class="form-control" name="formulaireMajEmprunt"
				value="Mettre à Jour">
		</div>
<?php
    }
    ?>
</form>
</div>
<?php
}