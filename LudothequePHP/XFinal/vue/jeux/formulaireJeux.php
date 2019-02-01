<?php
use DAO\Jeu\JeuDAO;

function afficherJeu()
{
    ?>
<h1>Gérér les Jeux</h1>
<form action="index.php?page=jeux" method="post" class="AfficheJeu">
	<table style="width: 90%">
		<tr>
			<th><input type="submit" name="miseaJour" value="Mettre à jour" /></th>
			<th><input type="submit" name="supprimer" value="Supprimer Jeu" /></th>
			<th><input type="submit" name="ajouter" value="Ajouter Jeu" /></th>
		</tr>

		<tr>
			<th>Id</th>
			<th>Règle</th>
			<th>Titre</th>
			<th>Année de sortie</th>
			<th>Auteur</th>
			<th>Id Editeur</th>
			<th>Catégorie</th>
			<th>Univers</th>
			<th>Contenu Initial</th>

		</tr>
		<tr>
			<th colspan="8"></th>
		</tr>
		<?php

    $jeux = JeuDAO::getJeu();
    foreach ($jeux as $jeu) {
        $rep .= "<tr><td>" . $jeu->getIdJeu();
        $rep .= "</td><td><a href=\"" . $jeu->getRegle() . "\">Règle du jeu</a>";
        $rep .= "</td><td>" . $jeu->getTitre();
        $rep .= "</td><td>" . $jeu->getAnneeSortie();
        $rep .= "</td><td>" . $jeu->getAuteur();
        $rep .= "</td><td>" . $jeu->getEditeur()->getIdEditeur();
        $rep .= "</td><td>" . $jeu->getCategorie();
        $rep .= "</td><td>" . $jeu->getUnivers();
        $rep .= "</td><td>" . $jeu->getContenuInitial();
        $rep .= "</td><td><input type=\"radio\" name=\"idJeu\ value=\"" . $jeu->getIdJeu() . "\" label for =\"idJeu\"></td></tr>";
    }
    echo $rep;
}
?>

	</table>

</form>

<?php

function formulaireMaj()
{
    ?>
<div class="form-group">
	<form class="formulaireMaj" method="post" action="index.php?page=jeux">
    <?php
    $dao = new JeuDAO();
    $jeu = $dao->read($_POST['idJeu']);
    ?>
    
	<table style="width: 60%">
			<tr>
				<label for="Regle">Règle :</label><select class="form-control">
				<option value="" selected=" ">Aucune</option>
				</select>
				<td><input type="text" name="regle"
					value="<?php echo $jeu->getRegle();?>"></td>
			</tr>

			<tr>
				<td>Titre :</td>
				<td><input type="text" name="titre"
					value="<?php echo $jeu->getTitre();?>"></td>
			</tr>

			<tr>
				<td>Année de Sortie :</td>
				<td><input type="text" name="anneeSortie"
					value="<?php echo $jeu->getAnneeSortie();?>"></td>
			</tr>

			<tr>
				<td>Auteur :</td>
				<td><input type="text" name="auteur"
					value="<?php echo $jeu->getAuteur();?>"></td>
			</tr>

			<tr>
				<td>Id Editeur :</td>
				<td><input type="text" name="idEditeur"
					value="<?php echo $jeu->getIdEditeur();?>"></td>
			</tr>

			<tr>
				<td>Catégorie :</td>
				<td><input type="text" name="categorie"
					value="<?php echo $jeu->getCategorie();?>"></td>

			</tr>

			<tr>
				<td>Univers :</td>
				<td><input type="text" name="univers"
					value="<?php echo $jeu->getUnivers();?>"></td>
			</tr>

			<tr>
				<td>Contenu Initial :</td>
				<td><input type="text" name="contenuInitial"
					value="<?php echo $jeu->getContenuInitial();?>"></td>
			</tr>

			<tr>
				<td colspan="3">
					<button type="submit" name="maj">Mettre à jour Jeu</button>
				</td>
				<td colspan="3"><button type="submit" name="supprimer">Supprimer Jeu</button></td>

			</tr>
		<?php

    afficherFormulaireAjout()?>
    
    <?php

    ?>
</table>
	</form>
</div>
<?php }?>
<?php

function afficherFormulaireAjout()
{
    $daoJeu = new JeuDAO();
    $jeu = $daoJeu->read($_POST['idJeu']);
    ?>
<form method="post" action="index.php?page=jeux" class="ajoutJeu">
	<table>
		<tr>

			<td>Id Règle :</td>
			<td><input type="url" name="idRegle" value=" "></td>

		</tr>
		<tr>

			<td>Titre :</td>
			<td><input type="text" name="titre" value=" "></td>

		</tr>
		<tr>

			<td>Année de Sortie :</td>
			<td><input type="text" name="anneeSortie" value=""></td>

		</tr>
		<tr>

			<td>Auteur :</td>
			<td><input type="text" name="auteur" value=" "></td>

		</tr>
		<tr>

			<td>Id Editeur :</td>
			<td><input type="text" name="idEditeur" value=" "></td>

		</tr>
		<tr>

			<td>Catégorie :</td>
			<td><input type="text" name="categorie" value=" "></td>

		</tr>
		<tr>

			<td>Univers :</td>
			<td><input type="text" name="univers" value=" "></td>

		</tr>
		<tr>

			<td>Contenu Initial :</td>
			<td><input type="text" name="contenu" value=" "></td>

		</tr>
		<tr>
			<td colspan="3">
				<button type="submit" name="maj">Ajouter Jeu</button>
			</td>

		</tr>
	</table>
</form>


<?php }?>


