<!-- Contenu HTML affichage des formulaires -->
<?php
use DAO\Adherent\AdherentDAO;
use DAO\Personne\PersonneDAO;
use DAO\Reglement\ReglementDAO;

function afficherGestionPersonne()
{
    ?>
<form method="post" action="index.php?page=personnes">
	<table class="table">
		<thead>
			<tr>
				<td colspan="4"><button type="submit" class="btn btn-success"
						name="ajouter">Ajouter une Nouvelle Personne</button></td>
			</tr>
			<tr>
				<th>Identifiant</th>
				<th>NOM Prénom</th>
				<th>Date de Naissance</th>
				<th><button type="submit" class="btn btn-danger" name="supprimer">Supprimer</button>
					<button type="submit" class="btn btn-primary" name="maj">Mettre à Jour</button></th>
			</tr>
		</thead>
		<tbody>

<?php

    $listePersonne = PersonneDAO::getPersonnes();
    if (array_key_exists(0, $listePersonne)) {
        foreach ($listePersonne as $personne) {
            ?>
			<tr>
				<td><?php echo $personne->getIdPersonne(); ?></td>
				<td><?php echo strtoupper($personne->getNom()) . " " . $personne->getPrenom(); ?></td>
				<td><?php echo $personne->getDateNaissance(); ?></td>
				<td><input type="radio" name="idPersonne"
					value="<?php echo $personne->getIdPersonne(); ?>"></td>
			</tr>
<?php
        }
    } else {
        ?>
			<tr>
				<td colspan="4">Aucune personne dans la base de donnée</td>
			</tr>
<?php
    }
    ?>
		</tbody>
	</table>
</form>
<?php
}

function afficherFormulaire($personne)
{
    $intituleFormulaire = ($personne->getIdPersonne() == "") ? "Ajout d'une nouvelle personne" : "Mise à jour d'un profil";
    $daoPersonne = new PersonneDAO();
    $daoAdherent = new AdherentDAO();
    $adherent = $daoAdherent->read($personne->getIdPersonne());
    $isAdherent = ($adherent->getIdPersonne() != "");
    $personne = $isAdherent ? $adherent : $personne;
    ?>
<h3><?php echo $intituleFormulaire; ?></h3>
<div class="col-lg-offset-4 col-lg-4">
	<form method="post" action="index.php?page=personnes">
		<div class="form-group">
			<label for="nom">Nom :</label> <input type="text"
				class="form-control" name="nom" id="nom"
				value="<?php echo $personne->getNom(); ?>">
		</div>
		<div class="form-group">
			<label for="prenom">Prénom :</label> <input type="text"
				class="form-control" name="prenom" id="prenom"
				value="<?php echo $personne->getPrenom(); ?>">
		</div>
		<div class="form-group">
			<label for="dateNaissance">Date de Naissance :</label> <input
				type="date" class="form-control" name="dateNaissance"
				id="dateNaissance"
				value="<?php echo $personne->getDateNaissance(); ?>">
		</div>
		<div class="form-group">
			<label for="mel">Adresse email :</label> <input type="text"
				class="form-control" name="mel" id="mel"
				value="<?php echo $personne->getMel(); ?>">
		</div>
		<div class="form-group">
			<label for="numeroTelephone">Numero Telephone :</label> <input
				type="text" class="form-control" name="numeroTelephone"
				id="numeroTelephone"
				value="<?php echo $personne->getNumeroTelephone(); ?>">
		</div>
		<fieldset>
			<legend>Coordonnées Postales</legend>
			<div class="form-group">
				<label for="rue">Adresse Postale:</label> <input type="text"
					class="form-control" name="rue" id="rue"
					value="<?php echo $personne->getCoordonnees()->getRue(); ?>">
			</div>
			<div class="form-group">
				<label for="codePostal">Code Postal :</label> <input type="text"
					class="form-control" name="codePostal" id="codePostal"
					value="<?php echo $personne->getCoordonnees()->getCodePostal(); ?>">
			</div>
			<div class="form-group">
				<label for="ville">Ville :</label> <input type="text"
					class="form-control" name="ville" id="ville"
					value="<?php echo $personne->getCoordonnees()->getVille(); ?>">
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
					value="<?php echo $personne->getDatePremiereAdhesion(); ?>">
			</div>
			<div class="form-group">
				<label for="dateFinAdhesion">Date Fin d'Adhésion :</label> <input
					type="date" class="form-control" name="dateFinAdhesion"
					id="dateFinAdhesion"
					value="<?php echo $personne->getDateFinAdhesion(); ?>">
			</div>
			<div class="form-group">
				<label for="reglement">Est soumis au règlement :</label> <select
					class="form-control" name="reglement" id="reglement">
<?php
        $listeReglement = ReglementDAO::getReglements();
        if (array_key_exists(0, $listeReglement)) {
            foreach ($listeReglement as $reglementBDD) {
                $selected = ($reglementBDD->getIdReglement() == $personne->getIdReglement()) ? "selected" : "";
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
        $listeBeneficaire = $daoAdherent->retrouverBeneficiaireAssocie($personne->getIdPersonne());
        if (array_key_exists(0, $listeBeneficaire)) {
            foreach ($listeBeneficaire as $beneficiaire) {
                ?>
                <input type="checkbox" class="form-control"
					id="beneficiaire" name="beneficiaire[]"
					value="<?php echo $beneficiaire->getIdPersonne(); ?>"> <?php echo $beneficiaire->getNom() . " " . $beneficiaire->getPrenom(); ?>
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
                if ($adherentBDD->getIdPersonne() != $personne->getIdPersonne()) {
                    $adherentAssocie = $daoPersonne->retrouverAdherentAssocie($personne->getIdPersonne());
                    if (array_key_exists(0, $adherentAssocie)) {
                        foreach ($adherentAssocie as $adherent) {
                            if ($adherentBDD->getIdPersonne() != $adherent->getIdPersonne()) {
                                ?>
                <option
						value="<?php echo $adherentBDD->getIdPersonne(); ?>"><?php echo $adherentBDD->getNom() . " " . $adherentBDD->getPrenom() . " ne(e) le " . $adherentBDD->getDateNaissance(); ?></option>
<?php
                            }
                        }
                    } else {
                        ?>
				<option value="<?php echo $adherentBDD->getIdPersonne(); ?>"><?php echo $adherentBDD->getNom() . " " . $adherentBDD->getPrenom() . " ne(e) le " . $adherentBDD->getDateNaissance(); ?></option>
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
		
<?php if ($personne->getIdPersonne() == "") {?>
	<div class="form-group">
			<input type="submit" class="form-control" name="formulaireAjout"
				value="Créer Nouvelle Personne">
		</div>
<?php
    } else {
        ?>
        <input type="hidden" name="idPersonne"
			value="<?php echo $personne->getIdPersonne(); ?>">
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