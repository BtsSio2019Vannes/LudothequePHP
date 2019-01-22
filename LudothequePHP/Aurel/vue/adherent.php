<?php

function afficherPersonnes(){
?>

<div class="infoLudo">
	<h1>Betton Ludique</h1>

	<div class="fenetreInfo" style="overflow-y: scroll;">
		<form class="affichePersonne" method="post"
			action="formulaireModifAdh.php">
			<table style="width: 100%">
				<tr>
					<td colspan="10"></td>
					<td></td>
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
					<th>
						<button type="submit" name="maj">Mettre à Jour</button>
					</th>
				</tr>

				<tr>
					<td colspan="10"></td>      
            <?php
            // On gère les include dès le début du programme
            // include ("../db/connexion.php");
            include ("../metier/adherent/adherents.php");
            include ("../db/Daos.php");

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
            </tr>
			</table>
		</form>
	</div>
</div>
<?php
 }
?>