<!-- Contenu HTML affichage des formulaires -->
<?php
use DAO\Jeu\JeuDAO;
use DAO\JeuPhysique\JeuPhysiqueDAO;

function afficherGestionJeuPhysique($listeJeuxPhysiquesTries)
{
    ?>
<form method="post" action="index.php?page=jeux">
	<table class="table">
		<thead>
			<tr>
				<td colspan="3"><button type="submit" class="btn btn-success"
						name="nouveauJeuPhysique">
						<span class="glyphicon glyphicon-plus"></span> Nouveau Jeu
					</button>
					<button type="submit" class="btn btn-danger"
						name="supprimerJeuPhysique">
						<span class="glyphicon glyphicon-remove"></span> Supprimer
					</button>
					<button type="submit" class="btn btn-primary"
						name="modifierJeuPhysique">
						<span class="glyphicon glyphicon-edit"></span> Mettre à Jour
					</button> <a href="index.php?page=jeux&action=gererJeux"
					class="btn btn-info"><span
						class="glyphicon glyphicon-exclamation-sign"></span> Gérer les
						catégories de jeu</a></td>
			</tr>
			<tr>
				<th>Nom du Jeu</th>
				<th>Contenu Actuel</th>
				<th></th>
			</tr>
		</thead>
		<tbody>

<?php
    $daoJeuPhysique = new JeuPhysiqueDAO();
    if (sizeof($listeJeuxPhysiquesTries)) {
        foreach ($listeJeuxPhysiquesTries as $listeJeuxPhysiques) {
            foreach ($listeJeuxPhysiques as $jeuPhysique) {
                $jeuPhysique = $daoJeuPhysique->read($jeuPhysique['idJeuPhysique']);
                ?>
			<tr>
				<td><?php echo $jeuPhysique->getTitre() . " n°" . $jeuPhysique->getIdJeuPhysique(); ?></td>
				<td><?php echo mb_substr($jeuPhysique->getContenuActuel(), 0, 50); ?></td>
				<td><input type="radio" name="idJeuPhysique"
					value="<?php echo $jeuPhysique->getIdJeuPhysique(); ?>"></td>
			</tr>
<?php
            }
        }
    } else {
        ?>
			<tr>
				<td colspan="3">Aucun jeu dans la base de données</td>
			</tr>
<?php
    }
    ?>
		
		
		</tbody>
	</table>
</form>
<?php
}

function afficherFormulaireJeuPhysique($jeuPhysique)
{
    $isNouveauJeuPhysique = ($jeuPhysique->getIdJeuPhysique() == "");
    $intituleFormulaire = $isNouveauJeuPhysique ? "Ajout d'un nouveau jeu physique" : "Modification d'un jeu physique";
    $idJeuPhysique = $isNouveauJeuPhysique ? "" : $jeuPhysique->getIdJeuPhysique();

    ?>
<h3><?php echo $intituleFormulaire; ?></h3>
    <a href="index.php?page=jeux"
					class="btn btn-warning"><span
						class="glyphicon glyphicon-backward"></span> Gérer les Jeux Physiques</a>
<div class="col-lg-offset-4 col-lg-4">
	<form method="post" action="index.php?page=jeux">
		<fieldset>
			<legend>Détails du jeu <?php echo $jeuPhysique->getTitre() . " n°" . $jeuPhysique->getIdJeuPhysique(); ?></legend>
			<div class="form-group">
				<label for="contenuActuel">Contenu Actuel :</label>
				<textarea class="form-control" name="contenuActuel"
					id="contenuActuel"><?php echo $jeuPhysique->getContenuActuel(); ?></textarea>
			</div>
			<div class="form-group">
				<label for="idJeu">Jeu :</label> <select class="form-control"
					name="idJeu" id="idJeu">
					<option value="" selected>Aucun</option>				
<?php
    $listeJeux = JeuDAO::getJeux();
    if (array_key_exists(0, $listeJeux)) {
        foreach ($listeJeux as $jeu) {
            $selected = ($jeu->getIdJeu() == $jeuPhysique->getIdJeu()) ? " selected" : "";
            ?>
                <option value="<?php echo $jeu->getIdJeu(); ?>"
						<?php echo $selected; ?>><?php echo $jeu->getTitre(); ?></option><?php
        }
    }
    ?>

				</select>
			</div>
		</fieldset>
<?php if ($isNouveauJeuPhysique) {?>
	<div class="form-group">
			<input type="submit" class="form-control"
				name="formulaireAjoutJeuPhysique" value="Créer Nouveau Jeu">
		</div>
<?php
    } else {
        ?>
        <div class="form-group">
			<input type="hidden" name="idJeuPhysique" value="<?php echo $idJeuPhysique; ?>"> <input
				type="submit" class="form-control" name="formulaireMajJeuPhysique"
				value="Mettre à Jour">
		</div>
<?php
    }
    ?>
</form>
</div>
<?php
}