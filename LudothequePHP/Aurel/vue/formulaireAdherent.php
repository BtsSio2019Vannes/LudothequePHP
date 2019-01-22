<?php
use DAO\Personne\PersonneDAO;
use DAO\Adherent\AdherentDAO;

function afficherPersonnes()
{
    ?>

<div class="infoLudo">
	<h1>Betton Ludique</h1>

	<div class="section" style="overflow-y: scroll;">
		<form class="affichePersonne" method="post"
			action="accueilAdherents.php">
			<table style="width: 80%">
				<tr>
				
						<th><button type="submit" name="maj">Mettre à Jour</button></th>
						<th><button type="submit" name="ajouter">Ajouter</button></th>
						
					
					<td colspan="9"></td>
					<td>
					</td>
				</tr>

				<tr>
					<th>n°</th>
					<th>Nom</th>
					<th>Prénom</th>					
					<th>Date de Naissance</th>
					<th>Coordonnées</th>
					<th>mél</th>
					<th>Numéro Téléphone</th>
					<th>Choix</th>
					
				</tr>

				<tr>
					<td colspan="9"></td>      
            <?php
    


    $personnes = \DAO\Personne\PersonneDAO::getPersonnes();

    foreach ($personnes as $personne) {

        $rep = "<tr><td>" . $personne->getIdPersonne();
        $rep .= "</td><td>" . $personne->getNom();
        $rep .= "</td><td>" . $personne->getPrenom();
        $rep .= "</td><td>" . $personne->getDateNaissance();
        $rep .= "</td><td>" . $personne->getCoordonnees();
        $rep .= "</td><td>" . $personne->getMel();
        $rep .= "</td><td>" . $personne->getNumeroTelephone();
        $rep .= "</td><td><input type=\"radio\" name=\"idPersonne\" value=\"" . $personne->getIdPersonne() . "\" label for=\"idPersonne\"></td></tr>";

        echo $rep;
    }
    ?>
            <td></td>
			
			</table>
		</form>

	</div>
</div>
<?php
}
?>

<?php
//=================================================================================================================
function formulaireModifPersonnes()
{
    ?>
<div class="fenetreFormulaire">

	<form class="formulaireModif" method="post"
		action="../controleur/accueilAdherents.php">
		<?php
    include ("../db/Daos.php");
    include ("../metier/adherents.php");

    if (isset($_POST['idPersonne'])) {
        // echo $_POST['idPersonne'];
        $daoPersonne = new PersonneDAO();
        $personne = $daoPersonne->read($_POST['idPersonne']);
        $coordonnee = $personne->getCoordonnees();
        // echo $coordonnee;
        // echo $personne;

        ?>
			<table>
			<tr>
				<td>Nom:</td>
				<td><input type="text" name="nom"
					value="<?php echo $personne->getNom();?>" /></td>
				<!-- 					<td>Id :</td> -->
				<td><input type="hidden" name="idPersonne"
					value="<?php echo $personne->getIdPersonne();?>" /></td>
				<!-- 					<td>IdAdresse :</td> -->
				<td><input type="hidden" name="idCoordonnees"
					value=" <?php echo $idCoordonnee=$personne->getCoordonnees()?>" />
				</td>
			</tr>

			<tr>
				<td>Prénom:</td>
				<td><input type="text" name="prenom"
					value="<?php echo $personne->getPrenom();?>" /></td>
			</tr>

			<tr>
				<td>Date de Naissance:</td>
				<td><input type="date" name="dateNaissance"
					value="<?php echo $personne->getDateNaissance();?>" /></td>
			</tr>

			<tr>
				<td>Rue:</td>
				<td><input type="text" name="rue"
					value="<?php echo $coordonnee->getRue();?>" /></td>
				<td>Code Postal:</td>
				<td><input type="text" name="codePostal"
					value="<?php echo $coordonnee->getCodePostal();?>" /></td>
				<td>Ville:</td>
				<td><input type="text" name="ville"
					value="<?php echo $coordonnee->getVille();?>" /></td>
			</tr>

			<tr>
				<td>Mel:</td>
				<td><input type="text" name="mel"
					value="<?php echo $personne->getMel()?>" /></td>
			</tr>

			<tr>
				<td>Numéro de Téléphone:</td>
				<td><input type="text" name="numTel"
					value="<?php echo $personne->getNumeroTelephone()?>" /></td>
			</tr>
			<tr>
				<td colspan="2"><button type="submit" name="modifier">Mettre à jour</button></td>
				<td colspan="2"><button type="submit" name="supprimer">Supprimer</button></td>
				<td colspan="2"><button type="submit" name="passerAdh">Passer
						Adhérent</button></td>
			</tr>
				
				<?php
        afficherFormulaireAdh($personne);
        ?>
			</table>
			<?php
    } else {
        echo "Vous n'avez pas choisi de Personne à modifier";
    }
    ?>
		</form>

</div>
<?php
}

?>

<?php
//========================================================================================================
function afficherFormulaireAdh($personne)
{
    // print_r($_POST);
    $daoAdherent = new AdherentDAO();

    if ($daoAdherent->isAdherent($personne)) {
        $adherent = $daoAdherent->read($_POST['idPersonne']);
        // echo $adherent;

        ?>


<tr>
	<td>Date Première adhésion :</td>
	<td><input type="text" name="datePremiereAdhesion"
		value="<?php echo $adherent->getDateAdhesion();?>" /></td>
	<td>Date Fin adhésion :</td>
	<td><input type="text" name="dateFinAdhesion"
		value="<?php echo $adherent->getDateFinAdhesion();?>" /></td>
</tr>
<tr>



<?php
    } else {
        echo "Cette personne n'est pas adhérente.<br/> Lui proposer un abonnement !";
    }
}
?>
  

