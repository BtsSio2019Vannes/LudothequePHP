<?php
namespace Emprunt{
    
    class Emprunts{
        
        private $idJeuPhysique;
        private $idAdherent = "";
        private $dateEmprunt = "";
        private $dateRetourEffectif;
        private $idAlerte;
        

        function __construct($idJeuPhysique, $idAdherent, $dateEmprunt, $dateRetourEffectif, $idAlerte){
            $this->idJeu = $idJeuPhysique;
            $this->idAdh = $idAdherent;
            $this->dateEmprunt = $dateEmprunt;
            $this->dateRetour = $dateRetourEffectif;
            $this->idAlerte = $idAlerte;
        }
        
        public function getIdJeu(){
            return $this->idJeu;
        }
        
        public function setIdJeu(){
            $this->idJeu = $IdJeuPhysique;
            return $this;
        }
    
        public function getIdAdh(){
            return $this->idAdh;
        }
        
        public function setIdAdh(){
            $this->idAdh = $idAdherent;
            return $this;
        }
        
        public function dateEmprunt(){
            return $this->dateEmprunt;
        }
        
        public function setDateEmprunt(){
            $this->dateEmprunt = $dateEmprunt;
            return $this;
        }
        
        public function dateRetour(){
            return $this->dateRetour;
        }
        
        public function setDateRetour(){
            $this->dateRetour = $dateRetour;
            return $this;
        }
        
        public function idAlerte(){
            return $this->idAlerte;
        }
        
        public function setIdAlerte(){
            $this->idAlerte = $idAlerte;
            return $this;
        }
    }
}
?>