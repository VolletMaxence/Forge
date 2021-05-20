<?php

    //Faire une liaison entre entite equipement et entiteequipement

    class Forge extends Map{
        /* PRIVATE */

        /* METHOD */
        public function __construct($bdd){
            parent::__construct($bdd);
        }            

        public function livraison($nbrEquipement){
            for($i=0; $i<$nbrEquipement; $i++){
                $equipement = new Equipement($this->_bdd);
                $this->addEquipement($equipement->createEquipementAleatoire()); 
            }
        }

        public function acheter($entite, $idMap, $idEntite){
            $req = "SELECT mapequipements.idEquipement, equipement.nom, equipement.valeur FROM `mapequipements`, `equipement` WHERE equipement.id = mapequipements.idEquipement AND `idMap` = $idMap";
            $RequetStatement = $this->_bdd->query($req);
            echo '<form method="post"><table>';
            while($Tab=$RequetStatement->fetch()){
                echo '<tr>';
                    echo '<td>'.$Tab[1].'</td>';
                    echo '<td>'.$Tab[2].'</td>';
                    echo '<td><input type="radio" name="radio[]" value="'.$Tab[0].'"></td>';
                echo '</tr>';
            }
            echo '</table><input type="submit" name="acheter" value="Acheter"></form>';

            // Récupère l'argent du user
            $req = "SELECT user.money FROM `user`, `entite` WHERE user.idPersonnage=entite.id AND entite.id = $idEntite";
            $RequetStatement = $this->_bdd->query($req);
            while($Tab=$RequetStatement->fetch()){
                $money = $Tab[0];
            }
            if(isset($_POST['radio'])){
                foreach($_POST['radio'] as $checkId){
                    $equipement = new equipement($this->_bdd);
                    $equipement->setEquipementById($checkId);
                    $valeur = $equipement->getValeur($checkId);
                }
                if($valeur > $money){
                    echo "Vous n'avez pas assez d'argent";
                }else{
                    $entite->addEquipement($checkId);
                    $this->removeEquipementById($checkId);
                    $money -= $valeur;
                    $req = "UPDATE `user`, `entite` SET user.money = $money WHERE user.idPersonnage=entite.id AND entite.id = $idEntite";
                    $RequetStatement = $this->_bdd->query($req);
                }
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

            // Récupère l'argent du user
            $req = "SELECT user.money FROM `user`, `entite` WHERE user.idPersonnage=entite.id AND entite.id = $idEntite";
            $RequetStatement = $this->_bdd->query($req);
            while($Tab=$RequetStatement->fetch()){
                $money = $Tab[0];
            }
            if(isset($_POST['checkbox'])){
                foreach($_POST['checkbox'] as $checkId){
                    $equipement = new equipement($this->_bdd);
                    $equipement->setEquipementById($checkId);
                    $valeur = $equipement->getValeur($checkId);
                    $equipements = $entite->removeEquipementByID($checkId);
                    $money += $valeur;
                }
            }
            $req = "UPDATE `user`, `entite` SET user.money = $money WHERE user.idPersonnage=entite.id AND entite.id = $idEntite";
            $RequetStatement = $this->_bdd->query($req);

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