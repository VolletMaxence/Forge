<?php

    //Faire une liaison entre entite equipement et entiteequipement

    class Forge extends Map{
        /* PRIVATE */

        /* METHOD */
        public function __construct($bdd){
            parent::__construct($bdd);
        }            

        public function acheter(){
            $req = "SELECT arme.rarete FROM `arme`, `forgeron` WHERE forgeron.arme = arme.idArme AND forgeron.id = 1";
            $RequetStatement=$this->_bdd->query($req);
            while($Tab=$RequetStatement->fetch()){
                $this->_rarete = $Tab[0];
            }
            if($this->_rarete == 'commun'){
                $this->_valeur = 10;
            }else if($this->_rarete == 'rare'){
                $this->_valeur = 100;
            }else if($this->_rarete == 'legendaire'){
                $this->_valeur = 1000;
            }

            if($this->_money <= $this->_valeur){
                echo "Vous n'avez pas assez d'argent";
            }else{
                $this->_money -= $this->_valeur;
                $req = "UPDATE `joueur` SET `money`=".$this->_money." WHERE `id` = 2";
                $RequetStatement=$this->_bdd->query($req);
            }
        }

        public function vendre($entite, $idEntite){
            $req = "SELECT entiteequipement.idEquipement, equipement.nom, equipement.valeur FROM `entiteequipement`, `equipement` WHERE equipement.id = entiteequipement.idEquipement AND `equipe` != 1 AND `idEntite` = $idEntite";
            $RequetStatement = $this->_bdd->query($req);
            $equipements = $entite->getEquipementNonPorte();
            echo '<form method="post"><table>';
            while($Tab=$RequetStatement->fetch()){
                echo '<tr>';
                    echo '<td>'.$Tab[1].'</td>';
                    echo '<td>'.$Tab[2].'</td>';
                    echo '<td><input type="checkbox" name="checkbox[]" value="'.$Tab[0].'"></td>';
                echo '</tr>';
            }
            echo '</table><input type="submit" name="vendre" value="Vendre"></form>';
            if(isset($_POST['checkbox'])){
                foreach($_POST['checkbox'] as $check){
                    $equipements = $entite->removeEquipementByID($check);
                    //$money += ;
                }
            }
            // Argent doit appartenir au user (faire une joiture)
            /*$req = "UPDATE `entite` SET `user` = $money WHERE id = $idEntite";
            $RequetStatement = $this->_bdd->query($req);*/

        }

        public function craft(){

        }

        public function decraft(){

        }

        public function getNomForge(){
            return 'Je suis la forge '.$this->_nom;
        }

        public function setForgeById($id){
            parent::setMapById($id);
        }
    }

?>