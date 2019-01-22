<?php
use Adherent\Adherent\Adherent;
use Adherent\Personne\Personne;

include ("../dao/Dao.php");

try {
    $bdd = new PDO('mysql:host=localhost;dbname=ludotheque;charset=utf8', 'root', '');
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}

?>
<html>
<head>
<title>Gestion Adherents</title>
<meta charset="utf-8" />
<link rel="stylesheet" type="text/css" href="../vue/css/adherents.css">


<body>
	<h1>Gestion des Personnes</h1>
	<nav>
		<ul>
			
			<a href="GestionAdherents.php"><img src="../vue/images/iconfinder_173_95790.png" title="Gestion des Personnes"></a>
			
			<a href="GestionJeux.php"><img src="../vue/images/iconfinder_chess_19227.png" title="Gestion des jeux"></a>
			
			<a href="GestionEmprunts.php"><img src="../vue/images/iconfinder_social__media__social_media__share__3259412.png" title="Gestion des emprunts"></a>
			
			<a href="GestionParametres.php"><img src="../vue/images/iconfinder_120_95711.png" title="Gestion Ludothèque"></a>
			
			<a href="../vue/formulaire.php"><img src="../vue/images/iconfinder_clipboard-document-office-form-application_3209374.png" title="Formulaire"></a>
			
			<a href="../vue/accueil.php"><img src="../vue/images/iconfinder_go-home_118770.png" title="Accueil"></a>
		</ul>


	</nav>
	<a href="../vue/formulaire.php?page=Maj"><input type="submit" name="maj"
		value="Mettre à jour Personne"></a>
	<a href="../vue/formulaire.php?page=ajout"><input type="submit" name="ajout"
		value="Ajouter Personne"></a>
	<a href="../vue/formulaire.php?page=supprimer"><input type="submit" name="supprimer"
		value="Supprimer Personne"></a>
	<br>
	<table class="echo">
		<tr>
			<td>Identifiant</td>
			<td>Nom</td>
			<td>Prénom</td>
			<td>Date de Naissance</td>
			<td>Id Coordonnees</td>
			<td>Mail</td>
			<td>Numéro Téléphone</td>


		</tr>
		<?php echo \Dao\Personne\PersonneDAO::getPersonne();?>
		</table>
<?php 

if (htmlspecialchars(isset($_POST['ajout']))) {
    $personne =new Personne("", "", "", "", "", "", "", "");
    afficherFomulaireAjout($personne);
}
elseif (htmlspecialchars(isset($_POST['supprimer'])) && htmlspecialchars(isset($_POST['personne']))){
    $Id = htmlspecialchars($_POST['personne']);
    $personne = new Personne($Id, "", "", "", "", "", "", "");
    $personne->supprimerPersonne();
    echo "<p><b>Personne bien supprimée !</b><br/><a href=\"index.php?page=personnes\">Retour</a></p>";
}
elseif(htmlspecialchars(isset($_POST['maj'])) && htmlspecialchars(isset($_POST['personne']))){
    $Id = htmlspecialchars($_POST['personne']);
    $personne = Personne::identifierPersonne($Id);
    
    if ($personne->rechercheAdherentAssocie() == "") {
        $adherent = Personne::identifierAdherent($personne);
    }
    else {
        $adherent = $personne->rechercheAdherentAssocie();
    }
    afficherFormulaireMiseAJO($personne);
}
elseif (htmlspecialchars(isset($_POST['formulaire ajout']))){
    $message = "Erreur";
    $nom = htmlspecialchars($_POST['nom']);
    $prenom = htmlspecialchars($_POST['prenom']);
    $dateNaissance = htmlspecialchars($_POST['dateNaissance']);
    $idCoordonnees = htmlspecialchars($_POST['idCoordonnes']);
    $mel = htmlspecialchars($_POST['mel']);
    $numTelephone = htmlspecialchars($_POST['numeroTelephone']);
    
    $idPersonneAssociee = htmlspecialchars($_POST['adherents']);
    
    $nom = isset($nom) && $nom != " " ? $nom : $message;
    $prenom = isset($prenom) && $prenom != "" ? $prenom : $message;
    $dateNaissance = isset($dateNaissance) && $dateNaissance != "" ? $dateNaissance : $message;
    $coordonnees = isset($idCoordonnees) && $idCoordonnees != "" ? $idCoordonnees : $message;
    $mel = isset($mel) && $mel != "" ? $mel : $message;
    $numero = isset($numTelephone) && $numTelephone != "" ? $numTelephone : $message;
    $personne = new Personne("", $nom, $prenom, $dateNaissance, $coordonnees, $mel, $numero);
    
    if ($nom != $message && $prenom != $message && $dateNaissance != $message && $mel != $message && $coordonnees != $message && $numero != $message) {
        $personne->ajouterPersonne();
        
        if ($idPersonneAssociee == "") {
            $idReglement = 1;
            $date = new DateTime();
            $datePremiereAdh = $date->format('Y-m-d');
            $date->modify('+1 year');
            $dateFinAdh = $date->format('Y-m-d');
            $valeurCaution = 15;
            $adherent = new Adherent($valeurCaution, $idReglement, $dateFinAdh, $datePremiereAdh);
            $adherent->setIdPersonne($personne->getIdPersonne());
            $adherent->passageAdherent();
        }else{
            $idAdherent = htmlspecialchars($_POST['adherents']);
            $personne->associeAdherent($idAdherent);
        }
                
    } else {
        echo $message;
        afficherFomulaireAjout($personne);
    }
}
elseif (htmlspecialchars(isset($_POST['formulaireMaj']))){
    $message = "Erreur";
    
    $nom = htmlspecialchars($_POST['nom']);
    $prenom = htmlspecialchars($_POST['prenom']);
    $dateNaissance = htmlspecialchars($_POST['dateNaissance']);
    $idCoordonnees = htmlspecialchars($_POST['idCoordonnes']);
    $mel = htmlspecialchars($_POST['mel']);
    $numTelephone = htmlspecialchars($_POST['numeroTelephone']);
    $idPersonneAssociee = htmlspecialchars($_POST['adherents']);
    
    $nom = isset($nom) && $nom != "" ? $nom : $message;
    $prenom = isset($prenom) && $prenom != "" ? $prenom : $message;
    $dateNaissance = isset($dateNaissance) && $dateNaissance != "" ? $dateNaissance : $message;
    $coordonnees = isset($coordonnees) && $coordonnees != "" ? $coordonnees : $message;
    $mel = isset($mel) && $mel != "" ? $mel : $message;
    $numero = isset($numero) && $numero != "" ? $numero : $message;
    
    $personne = new Personne($nom, $idCoordonnees, $dateNaissance, $prenom, $mel, $numTelephone);
    
    if ($nom != $message && $prenom != $message && $coordonnees != $message && $mel != $message && $dateNaissance != $message) {
        $personne->miseAJourPersonne();
        $personne->supprimerBeneficiaire();
        $personne->associeAdherent($idPersonneAssociee);
        
        if (htmlspecialchars(isset($_POST['passerAdherent']))) {
            $idReglement=1;
            $date = new DateTime();
            $datePremiereAdh = $date->format('Y-m-d');
            $date->modify('+1 year');
            $dateFinAdh = $date->format('Y-m-d');
            $valeurCaution = 15;
            $adherent = new Adherent($valeurCaution, $idReglement, $dateFinAdh, $datePremiereAdh, $idAdherent);
            $adherent->setIdPersonne($personne);
            $adherent->passerAdherent();
        }elseif (htmlspecialchars(isset($_POST['renouvellementAdhesion']))){
            $adherent= Personne::identifierAdherent($personne->getIdPersonne());
            $adherent->renouvellementAdhesion();
            
        }
        echo "<p><b>Personne bien mise à jour !</b><br/><a href=\"index.php?page=personnes\">Retour</a></p>";
    }else{
        echo $message;
        
        afficherFormulaireMiseAJO($personne);
    }
}
else{
    echo afficherGestionPersonnes();
}
?>
</body>

</html>