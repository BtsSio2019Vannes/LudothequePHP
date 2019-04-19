<!-- Contenu HTML affichage des formulaires -->
<?php
use DAO\Editeur\EditeurDAO;

function afficherGestionJeu($listeJeux)
{
    ?>
<form method="post" action="index.php?page=jeux">
	<table class="table">
		<thead>
			<tr>
				<td colspan="8"><button type="submit" class="btn btn-success"
						name="nouveauJeu">
						<span class="glyphicon glyphicon-plus"></span> Nouveau Jeu
					</button>
					<button type="submit" class="btn btn-danger" name="supprimerJeu">
						<span class="glyphicon glyphicon-remove"></span> Supprimer
					</button>
					<button type="submit" class="btn btn-primary" name="modifierJeu">
						<span class="glyphicon glyphicon-edit"></span> Mettre à Jour
					</button> <a href="index.php?page=jeux&action=gererEditeurs"
					class="btn btn-info"><span
						class="glyphicon glyphicon-exclamation-sign"></span> Gérer les
						éditeurs</a></td>
			</tr>
			<tr>
				<th>Nom du Jeu</th>
				<th>Catégorie</th>
				<th>Univers</th>
				<th>Editeur</th>
				<th>Auteur</th>
				<th>Année de sortie</th>
				<th>Règles</th>
				<th></th>
			</tr>
		</thead>
		<tbody>

<?php
    if (sizeof($listeJeux)) {
        foreach ($listeJeux as $jeu) {
            ?>
			<tr>
				<td><?php echo $jeu->getTitre(); ?></td>
				<td><?php echo $jeu->getCategorie(); ?></td>
				<td><?php echo $jeu->getUnivers(); ?></td>
				<td><?php echo $jeu->getEditeur()->getNom(); ?></td>
				<td><?php echo $jeu->getAuteur(); ?></td>
				<td><?php echo $jeu->getAnneeSortie(); ?></td>
				<td><a href="<?php echo $jeu->getRegle(); ?>">Règles</a></td>
				<td><input type="radio" name="idJeu"
					value="<?php echo $jeu->getIdJeu(); ?>"></td>
			</tr>
<?php
        }
    } else {
        ?>
			<tr>
				<td colspan="8">Aucun jeu dans la base de données</td>
			</tr>
<?php
    }
    ?>
		
		
		</tbody>
	</table>
</form>
<?php
}

function afficherFormulaireJeu($jeu)
{
    $isNouveauJeu = ($jeu->getIdJeu() == "");
    $intituleFormulaire = $isNouveauJeu ? "Ajout d'un nouveau jeu" : "Modification d'un jeu";
    $idJeu = $isNouveauJeu ? "" : $jeu->getIdJeu();

    ?>
<h3><?php echo $intituleFormulaire; ?></h3>
    <a href="index.php?page=jeux&action=gererJeux"
					class="btn btn-warning"><span
						class="glyphicon glyphicon-backward"></span> Gérer les Jeux</a>
<div class="col-lg-offset-4 col-lg-4">
	<form method="post" action="index.php?page=jeux">
		<fieldset>
			<legend>Détails du jeu</legend>
			<div class="form-group">
				<label for="titre">Titre :</label> <input type="text"
					class="form-control" name="titre" id="titre"
					value="<?php echo $jeu->getTitre(); ?>">
			</div>
			<div class="form-group">
				<label for="categorie">Catégorie :</label> <input type="text"
					class="form-control" name="categorie" id="categorie"
					value="<?php echo $jeu->getCategorie(); ?>">
			</div>
			<div class="form-group">
				<label for="univers">Univers :</label> <input type="text"
					class="form-control" name="univers" id="univers"
					value="<?php echo $jeu->getUnivers(); ?>">
			</div>
			<div class="form-group">
				<label for="regle">Url de Règles du Jeu :</label> <input type="text"
					class="form-control" name="regle" id="regle"
					value="<?php echo $jeu->getRegle(); ?>">
			</div>
			<div class="form-group">
				<label for="contenuInitial">Contenu Initial :</label>
				<textarea class="form-control" name="contenuInitial"
					id="contenuInitial"><?php echo $jeu->getContenuInitial(); ?></textarea>
			</div>
			<div class="form-group">
				<label for="anneeSortie">Année de Sortie :</label> <select class="form-control"
					name="anneeSortie" id="anneeSortie">
					<?php
    for ($i = date('Y'); $i >= 1980; $i --) {
        $selected = ($i == $jeu->getAnneeSortie()) ? " selected" : "";
        ?>
					    <option value="<?php echo $i; ?>" <?php echo $selected; ?>><?php echo $i; ?></option>
					    <?php
    }
    ?>
					
									</select>
			</div>
						<div class="form-group">
				<label for="auteur">Auteur :</label> <input type="text"
					class="form-control" name="auteur" id="auteur"
					value="<?php echo $jeu->getAuteur(); ?>">
			</div>
		</fieldset>
		<fieldset>
			<legend>Editeur</legend>
			<div class="form-group">
				<label for="idEditeur">Editeur :</label> <select class="form-control"
					name="idEditeur" id="idEditeur">
					<option value="" selected>Aucun</option>				
<?php
        $listeEditeurs = EditeurDAO::getEditeurs();
        if (array_key_exists(0, $listeEditeurs)) {
            foreach ($listeEditeurs as $editeur) {
                $selected = ($editeur->getIdEditeur() == $jeu->getEditeur()->getIdEditeur()) ? "selected" : "";
                ?>
                <option value="<?php echo $editeur->getIdEditeur(); ?>"
						<?php echo $selected; ?>><?php echo $editeur->getNom(); ?></option>
<?php
            }
        }
        ?>
				</select>
			</div>
		</fieldset>
<?php if ($isNouveauJeu) {?>
	<div class="form-group">
			<input type="submit" class="form-control" name="formulaireAjoutJeu"
				value="Créer Nouveau Jeu">
		</div>
<?php
    } else {
        ?>
        <div class="form-group">
			<input type="hidden" name="idJeu" value="<?php echo $idJeu; ?>"> <input
				type="submit" class="form-control" name="formulaireMajJeu"
				value="Mettre à Jour">
		</div>
<?php
    }
    ?>
</form>
</div>
<?php
}