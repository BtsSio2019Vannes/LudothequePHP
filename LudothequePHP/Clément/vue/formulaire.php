<?php
use Dao\Personne\PersonneDAO;
use Dao\Adherent\AdherentDAO;
include '../metier/GestionAdherents.php';

function afficherGestionPersonnes()
{
    ?>

<form class="GestionPersonne" method="post" action="GestionAdherents.php?page=personne">
	<table>
		<tr>
			<button type="submit">Ajouter Nouvelle Personne</button>
			<td>Identifiant</td>
			<td>Nom</td>
			<td>Prénom</td>
			<td>Date de Naissance</td>
			<td>Id Coordonnees</td>
			<td>Mail</td>
			<td>Numéro Téléphone</td>
			<button type="submit">Mettre à jour Personne</button>
			<button type="submit">Supprimer Personne</button>
		</tr>
		
		<?php

    $personnes = PersonneDAO::getPersonne();
    foreach ($personnes as $personne) {
        $rep = "<tr><td>" . $personne->getIdPersonne();
        $rep .= "</td><td>" . $personne->getNom();
        $rep .= "</td><td>" . $personne->getPrenom();
        $rep .= "</td><td>" . $personne->getDateNaissance();
        $rep .= "</td><td>" . $personne->getIdCoordonnees();
        $rep .= "</td><td>" . $personne->getMel();
        $rep .= "</td><td>" . $personne->getNumeroTelephone();
        $rep .= "</td><td> <input type=\"checkbox\" name=\"personne\" value=\"" . $personne->getIdPersonne() . "\"></td></tr>";
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

function afficherFomulaireAjout($personne)
{
    $adherents = $personne->rechercheAdherentAssocie();
    ?>
<form action="../metier/GestionAdherents.php?page=ajouter" method="post">
	<table class="">
		<tr>
			<td>Nom <input type="text" name="nom"
				value="<?php echo $personne->getNomPersonne();?>">
			</td>
			<td>Prénom <input type="text" name="prénom"
				value="<?php echo $personne->getPrenomPersonne();?>">
			</td>
			<td>Date de Naissance <input type="text" name="date"
				value="<?php echo $personne->getDateNaissance();?>">
			</td>
			<td>Id Coordonnées <input type="text" name="id"
				value="<?php echo $personne->getIdCoordonnees();?>">
			</td>
			<td>Mail <input type="text" name="mail"
				value="<?php echo $personne->getMel()?>">
			</td>
			<td>Numéro Téléphone <input type="text" name="num"
				value="<?php echo $personne->getNumeroTelephone();?>">

			</td>

			<td>associé à l'adhérent <select>

					<option value="" selected></option>
			</select>
			</td>
		</tr>

	</table>

</form>


<?php
    $adherents = AdherentDAO::getAdherents();
    foreach ($adherents as $adherent) {
        if (in_array($adherent, $adherents)) {
            echo "<option value=\"" . $adherent->getIdPersonne() . "\">" . $adherent->getNom() . " " . $adherent->getPrenom() . " ne(e) le " . $adherent->getDateNaissance() . "</option>";
        }
        ;
    }
}
?>
<?php

function afficherFormulaireMiseAJO($personne)
{
    ?>
<form method="post" action="../metier/GestionAdherents.php?page=mettreàjour">
	<table>
		<tr>
			<td><input type="text" name="id"
				value="<?php echo $personne->getIdPersonne();?>"> <input type="text"
				name="nom" value="<?php echo $personne->getNomPersonne();?>"></td>
		</tr>
		<tr>
			<td><input type="text" name="prenom"
				value="<?php echo $personne->getPrenomPersonne()?>"></td>
		</tr>
		<tr>
			<td><input type="text" name="idCoordonnees"
				value="<?php echo $personne->getIdCoordonnees();?>"></td>
		</tr>
		<tr>
			<td><input type="date" name="Naissance"
				value="<?php echo $personne->getDateNaissance();?>"></td>
		</tr>
		<tr>
			<td><input type="text" name="mail"
				value="<?php echo $personne->getMel();?>"></td>
		</tr>
		<tr>
			<td><input type="text" name="Numero Telephone"
				value="<?php echo $personne->getNumeroTelephone();?>"></td>
		</tr>
		<tr>
		
		
		<tr>
   <?php
    if ($adherent->getIdPersonne() == $personne->getIdPersonne()) {
        ?>
   <td> <?php echo $adherent->getDatePremiereAdh(); ?></td>
			<td><?php echo $adherent->getDateFinAdh();?></td>
			<td><?php echo $adherent->getValeurCaution();?></td>
			<td></td>
		</tr>
		<tr>
		<?php if ($adherent->getIdPersonne() == $personne->getIdPersonne()) { ?>
		    <td><?php $benef = ($adherent->identifierBeneficiaire()) == " " ? "Aucun Bénéfciaire" : $adherent->identifierBeneficiaire();
            echo $benef;
            ?></td>

		</tr>
		<?php }?>
		
				
		<?php
    } else {
        if ($personne->getIdPersonne() != $adherent->getIdPrsonne() && $adherent->getIdPersonne()) {}
        ?>
		    <tr>
			<td>
		    <?php echo $adherent->getNomPersonne()." ". $adherent->getPrenomPersonne() ?>
		    </td>
		</tr>

	</table>



</form>
<?php
        $Id = $personne->rechercheAdherentAssocie();

        $liste = AdherentDAO::getAdherents();
        foreach ($liste as $adherents) {
            $Id = ($adherents->getIdPersonne() == $Id);
            echo "<option value=\"" . $adherents->getIdPersonne() . "\" " . $Id . ">" . $adherents->getNom() . " " . $adherents->getPrenom() . " ne(e) le " . $adherents->getDateNaissance() . "</option>";
        }
        ?>

  




<?php
    }
}

?>