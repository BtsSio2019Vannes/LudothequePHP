<?php

/* Formulaire d'accueil d'affichage de la liste des bénéficiaires et options possibles */
function afficherGestionPersonne()
{
    ?>

<form class="accueilPersonne" method="post"
	action="index.php?page=personnes">
	<table style="width: 50%">
		<tr>
			<td colspan="8"><button type="submit" name="ajouter">Ajouter une
					Nouvelle Personne</button></td>
			<td></td>
		</tr>
		<tr>
			<th>Identifiant</th>
			<th>Nom</th>
			<th>Prénom</th>
			<th>Date de Naissance</th>
			<th>Coordonnées</th>
			<th>mél</th>
			<th>Numéro Téléphone</th>
			<th><button type="submit" name="supprimer">Supprimer</button> <br />
				<button type="submit" name="maj">Mettre à Jour</button></th>
		</tr>

<?php

    $listePersonne = \DAO\Personne\PersonneDAO::getPersonnes();

    foreach ($listePersonne as $personne) {
        $rep = "<tr><td>" . $personne->getIdPersonne();
        $rep .= "</td><td>" . $personne->getNom();
        $rep .= "</td><td>" . $personne->getPrenom();
        $rep .= "</td><td>" . $personne->getDateNaissance();
        $rep .= "</td><td>" . $personne->getIdCoordonnees();
        $rep .= "</td><td>" . $personne->getMel();
        $rep .= "</td><td>" . $personne->getNumeroTelephone();
        $rep .= "</td><td><input type=\"radio\" name=\"personne\" value=\"" . $personne->getIdPersonne() . "\"></td></tr>";

        echo $rep;
    }
    ?>

			<tr>
			<th>Identifiant</th>
			<th>Nom</th>
			<th>Prénom</th>
			<th>Date de Naissance</th>
			<th>Coordonnées</th>
			<th>mél</th>
			<th>Numéro Téléphone</th>
			<th><button type="submit" name="supprimer">Supprimer</button> <br />
				<button type="submit" name="maj">Mettre à Jour</button></th>
		</tr>
		<tr>
			<td colspan="8"><button type="submit" name="ajouter">Ajouter une
					Nouvelle Personne</button></td>
			<td></td>
		</tr>
	</table>
</form>
<?php
}

/* Formulaire d'ajout de bénéficiaire */
function afficherFormulaireAjout($personne)
{
    $listeAdherentsAssocies = $personne->retrouverAdherentAssocie();
    ?>
<form class="ajoutModif" method="post" action="index.php?page=personnes">
	<table>
		<tr>
			<td><b>Nom :</b></td>
			<td><input type="text" name="nom"
				value="<?php echo $personne->getNom(); ?>"></td>
		</tr>
		<tr>
			<td><b>Prenom :</b></td>
			<td><input type="text" name="prenom"
				value="<?php echo $personne->getPrenom(); ?>"></td>
		</tr>
		<tr>
			<td><b>Date de Naissance :</b></td>
			<td><input type="text" name="dateNaissance"
				value="<?php echo $personne->getDateNaissance(); ?>"></td>
		</tr>
		<tr>
			<td><b>Adresse Postale :</b></td>
			<td><input type="text" name="coordonnees"
				value="<?php echo $personne->getIdCoordonnees(); ?>"></td>
		</tr>
		<tr>
			<td><b>Adresse email :</b></td>
			<td><input type="text" name="mel"
				value="<?php echo $personne->getMel(); ?>"></td>
		</tr>
		<tr>
			<td><b>Numero Telephone :</b></td>
			<td><input type="text" name="numero"
				value="<?php echo $personne->getNumeroTelephone(); ?>"></td>
		</tr>
		<tr>
			<td><b>Associer à l'adhérent : </b></td>
			<td><p>
					<select name="adherents">
						<option value="" selected>Aucun (Enregistrer comme adhérent)</option>
				
<?php

    $listeAdherents = \DAO\Adherent\AdherentDAO::getAdherents();
    foreach ($listeAdherents as $adherent) {
        if (in_array($adherent, $listeAdherentsAssocies)) {
            echo "<option value=\"" . $adherent->getIdPersonne() . "\">" . $adherent->getNom() . " " . $adherent->getPrenom() . " ne(e) le " . $adherent->getDateNaissance() . "</option>";
        }
    }
    ?>

				</select>
				</p></td>
		</tr>
		<tr>
			<td colspan="2"><input type="submit" name="formulaireAjout"
				value="Creer Nouvelle Personne"></td>
		</tr>
		<tr>
			<td colspan="2"><a href="index.php?page=personnes">Retour</a></td>
		</tr>
	</table>
</form>
<?php
}

/* Formulaire de mise à jour de bénéficiaire */
function afficherFormulaireMaj($personne)
{
    ?>
<form class="ajoutModif" method="post" action="index.php?page=personnes">
	<table>
		<tr>
			<td><b>Nom :</b></td>
			<td><input type="hidden" name="idPersonne"
				value="<?php echo $personne->getIdPersonne(); ?>"> <input
				type="text" name="nom" value="<?php echo $personne->getNom(); ?>"></td>
		</tr>
		<tr>
			<td><b>Prénom :</b></td>
			<td><input type="text" name="prenom"
				value="<?php echo $personne->getPrenom(); ?>"></td>
		</tr>
		<tr>
			<td><b>Date de Naissance :</b></td>
			<td><input type="text" name="dateNaissance"
				value="<?php echo $personne->getDateNaissance(); ?>"></td>
		</tr>
		<tr>
			<td><b>Adresse Postale :</b></td>
			<td><input type="text" name="coordonnees"
				value="<?php echo $personne->getIdCoordonnees(); ?>"></td>
		</tr>
		<tr>
			<td><b>Adresse email :</b></td>
			<td><input type="text" name="mel"
				value="<?php echo $personne->getMel(); ?>"></td>
		</tr>
		<tr>
			<td><b>Numero Téléphone :</b></td>
			<td><input type="text" name="numero"
				value="<?php echo $personne->getNumeroTelephone(); ?>"></td>
		</tr>
		<tr>
			<?php if ($adherent->getIdPersonne() == $personne->getIdPersonne()) { ?>
				<td><b>Date de 1ere adhésion :</b></td>
			<td><b><?php echo $adherent->getDatePremiereAdhesion(); ?></b></td>
		</tr>
		<tr>
			<td><b>Date de fin d'adhésion :</b></td>
			<td><b><?php echo $adherent->getDateFinAdhesion(); ?></b></td>
		</tr>
		<tr>
			<td><b>Valeur de la Caution :</b></td>
			<td><b><?php echo $adherent->getValeurCaution(); ?> euros.</b></td>
		</tr>
		<tr>
			<?php if ($adherent->getIdPersonne() == $personne->getIdPersonne()) { ?>
				<td><b>Bénéficiaire(s) associé(s) :</b></td>
			<td><p><?php
            $beneficiaire = ($adherent->retrouverBeneficiaire()) == "" ? "Aucun" : $adherent->retrouverBeneficiaire();
            echo $beneficiaire;
            ?></p></td>
		</tr>	
			<?php } ?>
			<tr>
			<td colspan="2"><br /> <input type="checkbox"
				name="renouvelerAdhesion" value="ok"><b> Renouveler Adhésion</b></td>
		</tr>
        <?php
    } else {
        if ($personne->getIdPersonne() != $adherent->getIdPersonne() && $adherent->getIdPersonne() != "") {
            ?>
			<tr>
			<td><b>Associé a l'adhérent :</b></td>
			<td><p><?php echo $adherent->getNom()." ".$adherent->getPrenom(); ?></p></td>
		</tr>
			<?php } ?>
			<tr>
			<td><b>Associer à l'adhérent : </b></td>
			<td><p>
					<select name="adherents">
						<option value="">Aucun (Enregistrer comme adhérent)</option>
					
<?php

        $idSelected = $personne->retrouverAdherentAssocie();

        $listeAdherents = \DAO\Adherent\AdherentDAO::getAdherents();
        foreach ($listeAdherents as $adherent) {
            $selected = ($adherent->getIdPersonne() == $idSelected) ? "selected" : "";
            echo "<option value=\"" . $adherent->getIdPersonne() . "\" " . $selected . ">" . $adherent->getNom() . " " . $adherent->getPrenom() . " ne(e) le " . $adherent->getDateNaissance() . "</option>";
        }

        ?>

				</select>
				</p></td>
		</tr>
			<?php } ?>

			<tr>
			<td colspan="2"><input type="submit" name="formulaireMaj"
				value="Mettre a Jour la Personne"></td>
		</tr>
		<tr>
			<td colspan="2"><a href="index.php?page=personnes">Retour</a></td>
		</tr>
	</table>
</form>
<?php
}
?>