<?php
use DAO\Jeu\JeuDAO;

function afficherJeu()
{
    ?>
<h1>Gérér les Jeux</h1>
<form action="index.php?page=jeux" method="post" class="AfficheJeu">
	<table style="width: 90%">
		

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
        $rep .= "</td><td><a href=\"" . $jeu->getIdRegle() . "\">Règle du jeu</a>";
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

function formulaireMaj($jeu)
{
    ?>

<form class="formulaireMaj" method="post" action="../../controleur/accueilJeux.php">
    <?php

    ?>
    <table>

		<tr>
			<td>Règle :</td>
			<td><input type="url" name="idRegle"
				value="<?php echo $jeu->getIdRegle();?>"></td>
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

    afficherFormualireAjout($jeu)?>
    </table>
    <?php

    ?>

</form>

<?php }?>
<?php

function afficherFomulaireAjout($jeu)
{
    ?>
<form method="post" action="index.php?page=jeux" class="majJeu">
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


