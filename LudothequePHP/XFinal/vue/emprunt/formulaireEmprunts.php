<!-- Contenu HTML affichage des formulaires -->
<?php
use DAO\Adherent\AdherentDAO;
use DAO\Emprunt\EmpruntDAO;
use DAO\Reglement\ReglementDAO;

function afficherGestionEmprunt($listeEmprunts)
{
    ?>
<form method="post" action="index.php?page=emprunts">
	<table class="table">
		<thead>
			<tr>
				<td colspan="4"><button type="submit" class="btn btn-success"
						name="nouvelEmprunt">Nouvel Emprunt</button></td>
			</tr>
			<tr>
				<th>Date d'emprunt</th>
				<th>Date de retour</th>
				<th>Adhérent</th>
				<th>Jeu</th>
				<th>Alerte</th>
				<th><button type="submit" class="btn btn-danger" name="supprimer">Supprimer</button>
					<button type="submit" class="btn btn-primary" name="maj">Mettre à Jour</button></th>
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
				<td><input type="radio" name="idEmprunt" value="<?php echo $jeuPhysique->getIdJeuPhysique()."/".$adherent->getIdPersonne()."/".$emprunt['dateEmprunt']; ?>"></td>
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

function afficherFormulaire($emprunt)
{
    $intituleFormulaire = ($emprunt->getIdEmprunt() == "") ? "Ajout d'une nouvelle emprunt" : "Mise à jour d'un profil";
    $daoEmprunt = new EmpruntDAO();
    $daoAdherent = new AdherentDAO();
    $adherent = $daoAdherent->read($emprunt->getIdEmprunt());
    $isAdherent = ($adherent->getIdEmprunt() != "");
    $emprunt = $isAdherent ? $adherent : $emprunt;
    ?>
<h3><?php echo $intituleFormulaire; ?></h3>
<div class="col-lg-offset-4 col-lg-4">
	<form method="post" action="index.php?page=emprunts">
		<div class="form-group">
			<label for="nom">Nom :</label> <input type="text"
				class="form-control" name="nom" id="nom"
				value="<?php echo $emprunt->getNom(); ?>">
		</div>
		<div class="form-group">
			<label for="prenom">Prénom :</label> <input type="text"
				class="form-control" name="prenom" id="prenom"
				value="<?php echo $emprunt->getPrenom(); ?>">
		</div>
		<div class="form-group">
			<label for="dateNaissance">Date de Naissance :</label> <input
				type="date" class="form-control" name="dateNaissance"
				id="dateNaissance"
				value="<?php echo $emprunt->getDateNaissance(); ?>">
		</div>
		<div class="form-group">
			<label for="mel">Adresse email :</label> <input type="text"
				class="form-control" name="mel" id="mel"
				value="<?php echo $emprunt->getMel(); ?>">
		</div>
		<div class="form-group">
			<label for="numeroTelephone">Numero Telephone :</label> <input
				type="text" class="form-control" name="numeroTelephone"
				id="numeroTelephone"
				value="<?php echo $emprunt->getNumeroTelephone(); ?>">
		</div>
		<fieldset>
			<legend>Coordonnées Postales</legend>
			<div class="form-group">
				<label for="rue">Adresse Postale:</label> <input type="text"
					class="form-control" name="rue" id="rue"
					value="<?php echo $emprunt->getCoordonnees()->getRue(); ?>">
			</div>
			<div class="form-group">
				<label for="codePostal">Code Postal :</label> <input type="text"
					class="form-control" name="codePostal" id="codePostal"
					value="<?php echo $emprunt->getCoordonnees()->getCodePostal(); ?>">
			</div>
			<div class="form-group">
				<label for="ville">Ville :</label> <input type="text"
					class="form-control" name="ville" id="ville"
					value="<?php echo $emprunt->getCoordonnees()->getVille(); ?>">
			</div>
		</fieldset>
		<fieldset>
			<legend>Informations Adhérent</legend>
	
<?php

    if ($isAdherent) {
        ?>
        
			<div class="form-group">
				<label for="datePremiereAdhesion">Date 1ère Adhésion :</label> <input
					type="date" class="form-control" name="datePremiereAdhesion"
					id="datePremiereAdhesion"
					value="<?php echo $emprunt->getDatePremiereAdhesion(); ?>">
			</div>
			<div class="form-group">
				<label for="dateFinAdhesion">Date Fin d'Adhésion :</label> <input
					type="date" class="form-control" name="dateFinAdhesion"
					id="dateFinAdhesion"
					value="<?php echo $emprunt->getDateFinAdhesion(); ?>">
			</div>
			<div class="form-group">
				<label for="reglement">Est soumis au règlement :</label> <select
					class="form-control" name="reglement" id="reglement">
<?php
        $listeReglement = ReglementDAO::getReglements();
        if (array_key_exists(0, $listeReglement)) {
            foreach ($listeReglement as $reglementBDD) {
                $selected = ($reglementBDD->getIdReglement() == $emprunt->getIdReglement()) ? "selected" : "";
                ?>
                <option
						value="<?php echo $reglementBDD->getIdReglement(); ?>"
						<?php echo $selected; ?>>n°<?php echo $reglementBDD->getIdReglement(); ?></option>
<?php
            }
        }
        ?>

				</select>
			</div>
			<div class="form-group">
				<label for="beneficiaire">Bénéficiaire(s) de l'adhésion :</label>
<?php
        $listeBeneficaire = $daoAdherent->retrouverBeneficiaireAssocie($emprunt->getIdEmprunt());
        if (array_key_exists(0, $listeBeneficaire)) {
            foreach ($listeBeneficaire as $beneficiaire) {
                ?>
                <input type="checkbox" class="form-control"
					id="beneficiaire" name="beneficiaire[]"
					value="<?php echo $beneficiaire->getIdEmprunt(); ?>"> <?php echo $beneficiaire->getNom() . " " . $beneficiaire->getPrenom(); ?>
<?php
            }
        }
        ?>
			</div>
<?php
    } else {
        ?>
			<div class="form-group">
				<label for="adherents">Associer à l'adhérent :</label> <select
					class="form-control" name="adherents" id="adherents">
					<option value="" selected>Aucun</option>
					<option value="passerAdherent">Enregistrer comme adhérent</option>
				
<?php
        $listeAdherents = AdherentDAO::getAdherents();
        if (array_key_exists(0, $listeAdherents)) {
            foreach ($listeAdherents as $adherentBDD) {
                if ($adherentBDD->getIdEmprunt() != $emprunt->getIdEmprunt()) {
                    $adherentAssocie = $daoEmprunt->retrouverAdherentAssocie($emprunt->getIdEmprunt());
                    if (array_key_exists(0, $adherentAssocie)) {
                        foreach ($adherentAssocie as $adherent) {
                            if ($adherentBDD->getIdEmprunt() != $adherent->getIdEmprunt()) {
                                ?>
                <option
						value="<?php echo $adherentBDD->getIdEmprunt(); ?>"><?php echo $adherentBDD->getNom() . " " . $adherentBDD->getPrenom() . " ne(e) le " . $adherentBDD->getDateNaissance(); ?></option>
<?php
                            }
                        }
                    } else {
                        ?>
				<option value="<?php echo $adherentBDD->getIdEmprunt(); ?>"><?php echo $adherentBDD->getNom() . " " . $adherentBDD->getPrenom() . " ne(e) le " . $adherentBDD->getDateNaissance(); ?></option>
<?php
                    }
                }
            }
        }
        ?>

				</select>
			</div>
<?php
    }
    ?>
		</fieldset>
		
<?php if ($emprunt->getIdEmprunt() == "") {?>
	<div class="form-group">
			<input type="submit" class="form-control" name="formulaireAjout"
				value="Créer Nouvelle Emprunt">
		</div>
<?php
    } else {
        ?>
        <input type="hidden" name="idEmprunt"
			value="<?php echo $emprunt->getIdEmprunt(); ?>">
		<div class="form-group">
			<input type="submit" class="form-control" name="formulaireMaj"
				value="Mettre à Jour">
		</div>
<?php
    }
    ?>
</form>
</div>
<?php
}