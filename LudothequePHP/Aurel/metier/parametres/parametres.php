<?php

namespace Parametre{
    
    class Reglement{
        
        private $idReglement;
        private $nbrJeux;
        private $duree;
        private $retardTolere;
        private $valeurCaution;
        private $coutAdhesion;
        
        function __construct($idReglement, $nbrJeux, $duree, $retardTolere, $valeurCaution, $coutAdhesion){
            $this->idReglement = $idReglement;
            $this->nbrJeux = $nbrJeux;
            $this->duree = $duree;
            $this->retardTolere = $retardTolere;
            $this->valeurCaution = $valeurCaution;
            $this->coutAdhesion =$coutAdhesion;
            
            
        }
        
        public function getIdReglement()
        {
            return $this->idReglement;
        }
    
        public function getNbrJeux()
        {
            return $this->nbrJeux;
        }
    
        public function getDuree()
        {
            return $this->duree;
        }
    
        public function getRetardTolere()
        {
            return $this->retardTolere;
        }
    
        public function getValeurCaution()
        {
            return $this->valeurCaution;
        }
    
        public function getCoutAdhesion()
        {
            return $this->coutAdhesion;
        }
    
        public function setIdReglement($idReglement)
        {
            $this->idReglement = $idReglement;
        }
    
        public function setNbrJeux($nbrJeux)
        {
            $this->nbrJeux = $nbrJeux;
        }
    
        public function setDuree($duree)
        {
            $this->duree = $duree;
        }
    
        public function setRetardTolere($retardTolere)
        {
            $this->retardTolere = $retardTolere;
        }
    
        public function setValeurCaution($valeurCaution)
        {
            $this->valeurCaution = $valeurCaution;
        }
    
        public function setCoutAdhesion($coutAdhesion)
        {
            $this->coutAdhesion = $coutAdhesion;
        }      
    }
}









?>