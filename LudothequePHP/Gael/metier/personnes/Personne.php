<?php

use Adherent\Personne;

function identifierPersonne($idPersonne)
{
    $daoPersonne = new \DAO\Personne\PersonneDAO();
    $personne = $daoPersonne->read($idPersonne);

    return $personne;
}

function ajouterPersonne($personne)
{
    $daoPersonne = new \DAO\Personne\PersonneDAO();
    $daoPersonne->create($personne);
}

function supprimerPersonne($personne)
{
    $adherent = Personne::identifierAdherent($personne->getIdPersonne());
    if ($adherent->getIdPersonne() == $personne->getIdPersonne()) {
        $daoAdherent = new \DAO\Adherent\AdherentDAO();
        $daoAdherent->delete($personne);
    } else {
        $daoPersonne = new \DAO\Personne\PersonneDAO();
        $daoPersonne->delete($personne);
    }
}

function mettreAJourPersonne($personne)
{
    $daoPersonne = new \DAO\Personne\PersonneDAO();
    $daoPersonne->update($personne);
}

function identifierAdherent($idPersonne)
{
    $daoAdherent = new \DAO\Adherent\AdherentDAO();
    $adherent = $daoAdherent->read($idPersonne);
    return $adherent;
}

function passerAdherent($personne)
{
    $daoAdherent = new \DAO\Adherent\AdherentDAO();
    $daoAdherent->create($personne);
}

function associerAdherent($personne, $idAdherent)
{
    $daoPersonne = new \DAO\Personne\PersonneDAO();
    $daoPersonne->ajouterBeneficiaire($idAdherent, $personne->getIdPersonne());
}

function retrouverAdherentAssocie($personne)
{
    $daoPersonne = new \DAO\Personne\PersonneDAO();
    $listeAdherents = $daoPersonne->retrouverAdherentAssocie($personne->getIdPersonne());
    return $listeAdherents;
}

function supprimerBeneficiaire($personne)
{
    $daoPersonne = new \DAO\Personne\PersonneDAO();
    $daoPersonne->supprimerBeneficiaire($personne->getIdPersonne());
}

function retrouverBeneficiaire($personne)
{
    $daoAdherent = new \DAO\Adherent\AdherentDAO();
    $listeBeneficiaires = $daoAdherent->retrouverBeneficiaire($personne->getIdPersonne());
    return $listeBeneficiaires;
}

function renouvelerAdhesion($personne)
{
    $daoAdherent = new \DAO\Adherent\AdherentDAO();
    $adherent = $daoAdherent->read($personne->idAdherent);
    $dateFinAdhesion = $adherent->getDateFinAdhesion();
    $dateFinAdhesion = date('Y-m-d', strtotime("$dateFinAdhesion +1 year"));
    $adherent->setDateFinAdhesion($dateFinAdhesion);
    $daoAdherent->update($adherent);
}

?>