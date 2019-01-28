<?php
use DAO\Jeu\JeuDAO;

function afficherJeu()
{
    ?>
<h1>Gérér les Jeux</h1>
<form action="../../controleur/accueilJeux.php" method="post"
	class="AfficheJeu">
	<table>
		<tr>
			<td>Id</td>
			<td>Id Règle</td>
			<td>Titre</td>
			<td>Année de sorite</td>
			<td>Auteur</td>
			<td>Id Editeur</td>
			<td>Catégorie</td>
			<td>Univers</td>
			<td>Contenu Initial</td>
			<td><input type="submit" name="mise a jour">Mettre à jour</td>
			<td><input type="submit" name="supprimer">Supprimer Jeu</td>

		</tr>

	</table>

</form>
<?php

    $jeux = JeuDAO::getJeu();
    foreach ($jeux as $jeu) {
        $rep .= "<tr><td>" . $jeu->getIdJeu();
        $rep .= "<tr><td>" . $jeu->getIdRegle();
        $rep .= "<tr><td>" . $jeu->getTitre();
        $rep .= "<tr><td>" . $jeu->getAnneeSortie();
        $rep .= "<tr><td>" . $jeu->getAuteur();
        $rep .= "<tr><td>" . $jeu->getIdEditeur();
        $rep .= "<tr><td>" . $jeu->getCategorie();
        $rep .= "<tr><td>" . $jeu->getUnivers();
        $rep .= "<tr><td>" . $jeu->getContenuInitial();
        $rep .= "</td><td><input type=\"radio\" name=\"idJeu\ value=\"" . $jeu->getIdJeu() . "\" label for =\"idJeu\"></tr></td>";
    }
    echo $rep;
}
?>
<?php

function formulaireMaj($jeu)
{
    ?>

<form class="formulaireMaj" method="post"
	action="../controleur/accueilJeux.php">
    <?php

    ?>
    <table>

		<tr>
			<td>Id Règle :</td>
			<td><input type="text" name="idRegle"
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
<form method="post" action="../controleur/accueilJeux.php">
	<table>
		<tr>

			<td>Id Règle :</td>
			<td><input type="text" name="idRegle" value=" "></td>

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


